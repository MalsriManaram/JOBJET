<?php
// === 1. SETUP & CONFIGURATION ===
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require './vendor/autoload.php';
include 'config.php';

$page_title = 'Sign Up Form';
$msg = '';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
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
        header('Location: signup.php?error=password');
        exit;
    } else {
        $stmt = $conn->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            header('Location: signup.php?error=exists');
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
                $mail->Username = $_ENV['SMTP_USER'];
                $mail->Password = $_ENV['SMTP_PASS'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = $_ENV['SMTP_PORT'];

                $mail->setFrom($_ENV['SMTP_USER'], 'JobJet');
                $mail->addAddress($email, $first_name.' '.$last_name);

                $mail->isHTML(true);
                $mail->Subject = 'Verify Your Email Address for JobJet';
                $verification_link = 'http://localhost/JOBJET/PHP/login.php?verification='.$code;

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
                        header('Location: signup.php?success=1');
                        exit;
                    } else {
                        $conn->rollback();
                        if (isset($insert_stmt) && $insert_stmt) {
                            $insert_stmt->close();
                        }
                        // optionally: clear any partial cookie / data here
                        header('Location: signup.php?error=db');
                        exit;
                    }
                } else {
                    // Mail failed
                    header('Location: signup.php?error=mail');
                    exit;
                }
            } catch (Exception $e) {
                header('Location: signup.php?error=mail');
                exit;
            }
        }
        $stmt->close();
    }
}
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>

    <link rel="stylesheet" href="/JOBJET/CSS/signup.css" type="text/css" media="all" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
            <div class="card signup-card flex-md-row">
                <div class="row g-0 w-100">
                
                <!-- Left Side (Image - 50%) -->
                <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center p-0">
                <img src="../IMAGERS/SIGNUP.png" alt="Signup Image" class="img-fluid w-100 h-100 rounded-start object-fit-cover">
                </div>


                <!-- Right Side (Form - 50%) -->
                <div class="col-md-6">
                    <div class="card-body p-4 p-md-5 position-relative">                    
                    <!-- Close Button -->
                    <div class="position-absolute top-0 end-0 m-4">
                        <a href="login.php" class="btn-close" aria-label="Close"></a>
                    </div>

                    <h2 class="text-center fw-bold mb-4">Create an Account</h2>

                    <form id="signupForm" action="" method="post" class="needs-validation" novalidate>
                        <?php echo $msg; ?>

                        <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstNameInput" class="form-label">First Name</label>
                            <input type="text" placeholder="First Name" class="form-control" id="firstNameInput" name="first_name" value="<?php echo isset($first_name) ? htmlspecialchars($first_name) : ''; ?>" required>
                            <div class="invalid-feedback">First name is required.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastNameInput" class="form-label">Last Name</label>
                            <input type="text" placeholder="Last Name" class="form-control" id="lastNameInput" name="last_name" value="<?php echo isset($last_name) ? htmlspecialchars($last_name) : ''; ?>" required>
                            <div class="invalid-feedback">Last name is required.</div>
                        </div>
                        </div>

                        <div class="mb-3">
                        <label for="emailInput" class="form-label">Email Address</label>
                        <input type="email" placeholder="Enter Your Email Address" class="form-control" id="emailInput" name="Email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                        <div class="invalid-feedback">Please enter a valid email address.</div>
                        </div>

                        <div class="mb-3">
                        <label for="passwordInput" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" placeholder="Enter Your Password" class="form-control text-danger" id="passwordInput" name="Password" required pattern="(?=.*\d)(?=.*[a-z]).{8,}" aria-describedby="passwordHelp">
                            <span class="input-group-text rounded-end toggle-password" onclick="togglePasswordVisibility('passwordInput')"><i class="fas fa-eye"></i></span>
                            <div class="invalid-feedback text-danger">Password must be at least 8 characters long and include a number.</div>
                        </div>
                        <div id="passwordHelp" class="form-text">Min. 8 characters, with at least one letter and one number.</div>
                        </div>

                        <div class="mb-4">
                        <label for="confirmPasswordInput" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" placeholder="Enter Your Confirm Password" class="form-control" id="confirmPasswordInput" name="confirm_password" required>
                            <span class="input-group-text toggle-password rounded-end" onclick="togglePasswordVisibility('confirmPasswordInput')"><i class="fas fa-eye"></i></span>
                            <div class="invalid-feedback text-danger">Please confirm your password.</div>
                        </div>
                        </div>

                        <div class="d-grid">
                        <button id="registerButton" name="submit" type="submit" class="btn btn-primary btn-lg">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            <span class="button-text">Register</span>
                        </button>
                        </div>

                        <p class="text-center mt-4 form-text">
                        Already have an account? <a href="login.php" class="text-decoration-none fw-bold">Log In</a>
                        </p>
                    </form>

                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <script>
        // Password visibility toggle function (reusable for both fields)
        function togglePasswordVisibility(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.nextElementSibling.querySelector('i');
            if (field.type === "password") {
                field.type = "text";
                icon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                field.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye");
            }
        }

        // Bootstrap form validation and button spinner logic
        (() => {
            'use strict';
            const form = document.getElementById('signupForm');
            const registerButton = document.getElementById('registerButton');
            const spinner = registerButton.querySelector('.spinner-border');
            const buttonText = registerButton.querySelector('.button-text');

            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    // If form is valid, show spinner
                    registerButton.disabled = true;
                    spinner.classList.remove('d-none');
                    buttonText.textContent = 'Processing...';
                }
                form.classList.add('was-validated');
            }, false);
        })();
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>