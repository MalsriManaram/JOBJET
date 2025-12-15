<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require VENDOR.'autoload.php';
include CONFIG.'config.php';

$page_title = 'Sign Up Form';
$msg = '';

// Load dotenv if not already loaded (assuming it's loaded in index.php, but for safety)
$dotenv = Dotenv\Dotenv::createImmutable(ROOT);
$dotenv->load();

// === 2. HANDLE MESSAGES AFTER REDIRECT ===
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $msg = "<div class='alert alert-success'>Registration successful! We've sent a verification link to your email address.</div>";
}
if (isset($_GET['error']) && $_GET['error'] == 'mail') {
    $msg = "<div class='alert alert-danger'>We could not send the verification email. Please try again.</div>";
}
if (isset($_GET['error']) && $_GET['error'] == 'exists') {
    $msg = "<div class='alert alert-danger'>This email address already exists. Please try another one.</div>";
}
if (isset($_GET['error']) && $_GET['error'] == 'password') {
    $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match.</div>";
}
if (isset($_GET['error']) && $_GET['error'] == 'db') {
    $msg = "<div class='alert alert-danger'>Something went wrong with the registration. Please try again.</div>";
}

// === 3. HANDLE FORM SUBMISSION ===
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['Email']);
    $password = $_POST['Password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        header('Location: '.BASE_URL.'auth/signup?error=password');
        exit;
    } else {
        $stmt = $conn->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            header('Location: '.BASE_URL.'auth/signup?error=exists');
            exit;
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $code = bin2hex(random_bytes(32));

            // === Try sending email FIRST ===
            $mail = new PHPMailer(true);
            try {
                $mail->SMTPDebug = SMTP::DEBUG_OFF;
                $mail->isSMTP();
                $mail->Host = $_ENV['SMTP_HOST'];
                $mail->SMTPAuth = true;
                $mail->Username = $_ENV['SMTP_USERNAME'];
                $mail->Password = $_ENV['SMTP_PASSWORD'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = $_ENV['SMTP_PORT'];

                $mail->setFrom($_ENV['SMTP_USERNAME'], 'JobJet');
                $mail->addAddress($email, $first_name.' '.$last_name);

                $mail->isHTML(true);
                $mail->Subject = 'Verify Your Email Address for JobJet';
                $verification_link = BASE_URL.'auth/login?verification='.$code;

                $mail->Body = "<table width='100%' cellpadding='0' cellspacing='0' border='0' style='background:#f7f9fc; padding:40px 0; font-family:Arial, sans-serif;'>
                            <tr>
                                <td align='center'>
                                <table width='600' cellpadding='0' cellspacing='0' border='0' style='background:#ffffff; border-radius:10px; box-shadow:0 4px 12px rgba(0,0,0,0.1); overflow:hidden;'>
                                    
                                    <!-- Header -->
                                    <tr>
                                    <td style='background:#0d6efd; padding:20px; text-align:center; color:#fff; font-size:22px; font-weight:bold;'>
                                        Welcome to JobJet 🚀
                                    </td>
                                    </tr>
                                    
                                    <!-- Body -->
                                    <tr>
                                    <td style='padding:30px; color:#333;'>
                                        <h2 style='margin:0 0 20px 0; font-size:20px; color:#0d6efd;'>Hi ".htmlspecialchars($first_name).",</h2>
                                        <p style='font-size:16px; line-height:1.6;'>
                                        Thank you for joining <strong>JobJet</strong>!<br>
                                        Please verify your email to activate your account.
                                        </p>
                                        
                                        <p style='text-align:center; margin:30px 0;'>
                                        <a href='".$verification_link."' 
                                            style='display:inline-block; background:#0d6efd; color:#fff; padding:14px 28px; 
                                                text-decoration:none; font-size:16px; border-radius:5px; font-weight:bold;'>
                                            ✅ Verify My Email
                                        </a>
                                        </p>
                                        
                                        <p style='font-size:14px; color:#555;'>
                                        If the button doesn’t work, copy and paste this link into your browser:<br>
                                        <a href='".$verification_link."' style='color:#0d6efd;'>".$verification_link."</a>
                                        </p>
                                    </td>
                                    </tr>
                                    
                                    <!-- Footer -->
                                    <tr>
                                    <td style='background:#f1f1f1; padding:15px; text-align:center; font-size:12px; color:#777;'>
                                        © ".date('Y').' JobJet. All rights reserved.<br>
                                        If you didn’t sign up, you can ignore this email.
                                    </td>
                                    </tr>
                                    
                                </table>
                                </td>
                            </tr>
                            </table>
                            ';

                // If mail is sent successfully → THEN insert user + profile
                if ($mail->send()) {
                    // Start a transaction so both inserts are atomic
                    $conn->begin_transaction();

                    $success = true;

                    // 1) Insert into users
                    $insert_stmt = $conn->prepare('INSERT INTO users (first_name, last_name, email, password, code) VALUES (?, ?, ?, ?, ?)');
                    if (!$insert_stmt) {
                        $success = false;
                        error_log('Prepare users insert failed: '.$conn->error);
                    } else {
                        $insert_stmt->bind_param('sssss', $first_name, $last_name, $email, $hashed_password, $code);
                        if (!$insert_stmt->execute()) {
                            $success = false;
                            error_log('Execute users insert failed: '.$insert_stmt->error);
                        }
                    }

                    // 2) Insert into profile (only if users insert succeeded)
                    if ($success) {
                        // get the inserted user id
                        $user_id = $conn->insert_id;
                        $gender = '';
                        // build full name
                        $full_name = trim($first_name.' '.$last_name);

                        $profile_stmt = $conn->prepare('INSERT INTO profile (p_id, full_name, pro_email, gender) VALUES (?, ?, ?, ?)');
                        if (!$profile_stmt) {
                            $success = false;
                            error_log('Prepare profile insert failed: '.$conn->error);
                        } else {
                            $profile_stmt->bind_param('isss', $user_id, $full_name, $email, $gender);
                            if (!$profile_stmt->execute()) {
                                $success = false;
                                error_log('Execute profile insert failed: '.$profile_stmt->error);
                            }
                            $profile_stmt->close();
                        }
                    }

                    // Commit or rollback
                    if ($success) {
                        $conn->commit();
                        if (isset($insert_stmt) && $insert_stmt) {
                            $insert_stmt->close();
                        }
                        header('Location: '.BASE_URL.'auth/signup?success=1');
                        exit;
                    } else {
                        $conn->rollback();
                        if (isset($insert_stmt) && $insert_stmt) {
                            $insert_stmt->close();
                        }
                        // optionally: clear any partial cookie / data here
                        header('Location: '.BASE_URL.'auth/signup?error=db');
                        exit;
                    }
                } else {
                    // Mail failed
                    header('Location: '.BASE_URL.'auth/signup?error=mail');
                    exit;
                }
            } catch (Exception $e) {
                header('Location: '.BASE_URL.'auth/signup?error=mail');
                exit;
            }
        }
        $stmt->close();
    }
}
$conn->close();
