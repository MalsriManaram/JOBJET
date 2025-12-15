<?php

include_once ROOT.'path.php';
session_start();
include CONFIG.'config.php';

$page_title = 'Login Form';
$msg = '';

// === 1. CHECK FOR "REMEMBER ME" COOKIE ===
if (isset($_COOKIE['remember_me']) && !isset($_SESSION['SESSION_EMAIL'])) {
    if (strpos($_COOKIE['remember_me'], ':') !== false) {
        list($user_id, $token) = explode(':', $_COOKIE['remember_me'], 2);

        // Join users with profile so we can get nick_name, pro_img, pro_email
        $stmt = $conn->prepare(
            'SELECT u.remember_token, u.pro_img, u.email AS email, u.id, u.first_name, u.last_name, u.code,
                    p.nick_name, p.pro_email
             FROM users u
             LEFT JOIN profile p ON p.p_id = u.id
             WHERE u.id = ? LIMIT 1'
        );

        if ($stmt) {
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows === 1) {
                $user = $result->fetch_assoc();

                if (!empty($user['remember_token']) && hash_equals($user['remember_token'], hash('sha256', $token))) {
                    if (empty($user['code'])) { // only auto-login if account is verified
                        session_regenerate_id(true);
                        // prefer profile email if provided
                        $session_email = !empty($user['pro_email']) ? $user['pro_email'] : $user['email'];

                        $_SESSION['email'] = $session_email;
                        $_SESSION['id'] = $user['id'];
                        $_SESSION['first_name'] = $user['first_name'];
                        $_SESSION['last_name'] = $user['last_name'];
                        $_SESSION['nick_name'] = isset($user['nick_name']) ? $user['nick_name'] : null;
                        if (!empty($user['pro_img'])) {
                            $_SESSION['pro_img'] = $user['pro_img'];
                        }

                        $stmt->close();
                        header('Location: '.BASE_URL.'home');
                        exit;
                    } else {
                        // Account not verified: clear cookie so we don't loop on it
                        setcookie('remember_me', '', time() - 3600, '/', '', false, true);
                    }
                } else {
                    // Token mismatch -> clear the cookie
                    setcookie('remember_me', '', time() - 3600, '/', '', false, true);
                }
            }
            $stmt->close();
        } else {
            error_log('Remember-me prepare failed: '.$conn->error);
        }
    }
}

// === 2. HANDLE ACCOUNT VERIFICATION ===
if (isset($_GET['verification'])) {
    $verification_code = $_GET['verification'];

    $stmt = $conn->prepare("UPDATE users SET code='' WHERE code=? LIMIT 1");
    if ($stmt) {
        $stmt->bind_param('s', $verification_code);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $msg = "<div class='alert alert-success'>Account verification was successful. You can now log in.</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Invalid or expired verification link.</div>";
        }
        $stmt->close();
    } else {
        error_log('Verification prepare failed: '.$conn->error);
        $msg = "<div class='alert alert-danger'>Server error during verification.</div>";
    }
}

// === 3. HANDLE LOGIN FORM SUBMISSION ===
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['Email']) ? trim($_POST['Email']) : '';
    $password = isset($_POST['Password']) ? $_POST['Password'] : '';

    if ($email === '' || $password === '') {
        $msg = "<div class='alert alert-danger'>Please provide both email and password.</div>";
    } else {
        // Search by users.email OR profile.pro_email, join profile to pull nick_name/pro_img/pro_email
        $stmt = $conn->prepare(
            'SELECT u.remember_token, u.pro_img, u.email AS email, u.id, u.first_name, u.last_name, u.password, u.code,
                    p.nick_name, p.pro_email
             FROM users u
             LEFT JOIN profile p ON p.p_id = u.id
             WHERE u.email = ? OR p.pro_email = ?
             LIMIT 1'
        );

        if ($stmt === false) {
            error_log('Login prepare failed: '.$conn->error);
            $msg = "<div class='alert alert-danger'>Server error. Try again later.</div>";
        } else {
            // bind the same $email to both placeholders
            $stmt->bind_param('ss', $email, $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows === 1) {
                $row = $result->fetch_assoc();

                if (password_verify($password, $row['password'])) {
                    if (!empty($row['code'])) {
                        $msg = "<div class='alert alert-warning'>Your account is not verified. Please check your email.</div>";
                    } else {
                        // Successful login - prefer profile email if present
                        $session_email = !empty($row['pro_email']) ? $row['pro_email'] : $row['email'];

                        session_regenerate_id(true);
                        $_SESSION['email'] = $session_email;
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['first_name'] = $row['first_name'];
                        $_SESSION['last_name'] = $row['last_name'];
                        $_SESSION['nick_name'] = isset($row['nick_name']) ? $row['nick_name'] : null;
                        if (!empty($row['pro_img'])) {
                            $_SESSION['pro_img'] = $row['pro_img'];
                        }

                        // Remember Me handling
                        if (!empty($_POST['remember_me'])) {
                            $token = bin2hex(random_bytes(32));
                            $hashedToken = hash('sha256', $token);
                            $user_id = $row['id'];

                            $token_stmt = $conn->prepare('UPDATE users SET remember_token = ? WHERE id = ?');
                            if ($token_stmt) {
                                $token_stmt->bind_param('si', $hashedToken, $user_id);
                                $token_stmt->execute();
                                $token_stmt->close();
                            } else {
                                error_log('Token update prepare failed: '.$conn->error);
                            }

                            $cookie_value = $user_id.':'.$token;

                            $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
                                        || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);

                            setcookie(
                                'remember_me',
                                $cookie_value,
                                time() + (86400 * 30),
                                '/',    // path
                                '',     // domain
                                $isSecure,
                                true    // httponly
                            );
                        }

                        if (headers_sent($file, $line)) {
                            error_log("Headers already sent in $file on line $line — redirect may fail.");
                        }

                        header('Location: '.BASE_URL.'home');
                        exit;
                    }
                } else {
                    $msg = "<div class='alert alert-danger'>Incorrect email or password.</div>";
                }
            } else {
                $msg = "<div class='alert alert-danger'>Incorrect email or password.</div>";
            }

            $stmt->close();
        }
    }
}

$conn->close();
?>