<?php

session_start();
include 'config.php';

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
                        header('Location: /JOBJET/PHP/home.php');
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

                        header('Location: /JOBJET/PHP/home.php');
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>

    <link rel="stylesheet" href="/JOBJET/CSS/login.css" type="text/css" media="all" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
      body { font-family: 'Poppins', sans-serif; background:#f8f9fa; }
      .login-card { margin-top: 40px; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 18px rgba(0,0,0,.08); }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
            <div class="card login-card flex-md-row">
                <div class="row g-0 w-100">

                <!-- Left Side (Form) -->
                <div class="col-md-6 col-12 d-flex">
                    <div class="card-body p-4 p-md-5 position-relative ">

                    <!-- Close Button -->
                    <div class="position-absolute  top-0 end-0 p-3">
                        <a href="home.php" class="btn-close" aria-label="Close"></a>
                    </div>

                    <h2 class="text-center fw-bold  my-4">Login to JobJet!</h2>

                    <form id="loginForm" action="" method="post" class="needs-validation" novalidate>
                        <?php echo $msg; ?>

                        <!-- Email -->
                        <div class="mb-3">
                        <label for="emailInput" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="emailInput" name="Email" placeholder="Enter Your Email"
                            value="<?php echo isset($_POST['Email']) ? htmlspecialchars($_POST['Email']) : ''; ?>" required>
                        <div class="invalid-feedback">
                            Please enter a valid email address.
                        </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="passwordInput" class="form-label">Password</label>
                            <a href="forgot-password.php" class="form-text text-decoration-none">Forgot Password?</a>
                        </div>
                        <div class="input-group has-validation">
                            <input type="password" class="form-control" id="passwordInput" name="Password" placeholder="Enter Your Password" required>
                            <span class="input-group-text toggle-password" onclick="togglePasswordVisibility('passwordInput')" style="cursor:pointer;">
                                <i class="fas fa-eye"></i>
                            </span>
                            <div class="invalid-feedback">
                            Please enter your password.
                            </div>
                        </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="form-check my-4">
                        <input class="form-check-input" type="checkbox" name="remember_me" id="rememberMeCheck">
                        <label class="form-check-label" for="rememberMeCheck">
                            Remember Me
                        </label>
                        </div>

                        <!-- Login Button -->
                        <div class="d-grid mt-4">
                        <button id="loginButton" name="submit" type="submit" class="btn btn-primary btn-lg">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            <span class="button-text">Login</span>
                        </button>
                        </div>

                        <!-- Sign Up Link -->
                        <p class="text-center mt-4 form-text">
                        Don’t have an account? <a href="signup.php" class="text-decoration-none fw-bold">Sign Up</a>
                        </p>
                    </form>

                    </div>
                </div>
                <!-- Right Side -->
                <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center p-0">
                    <img src="../IMAGERS/LOGIN001.png" alt="Login Image" class="img-fluid w-100 h-100 object-fit-cover">
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <script>
        // Password visibility toggle function
        function togglePasswordVisibility(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const toggleIcon = passwordField.nextElementSibling.querySelector('i');
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                passwordField.type = "password";
                toggleIcon.classList.replace("fa-eye-slash", "fa-eye");
            }
        }

        // Bootstrap validation + spinner
        (() => {
            'use strict';
            const form = document.getElementById('loginForm');
            const loginButton = document.getElementById('loginButton');
            const spinner = loginButton.querySelector('.spinner-border');
            const buttonText = loginButton.querySelector('.button-text');

            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    // Form valid - show spinner
                    loginButton.disabled = true;
                    spinner.classList.remove('d-none');
                    buttonText.textContent = 'Logging in...';
                }
                form.classList.add('was-validated');
            }, false);
        })();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
