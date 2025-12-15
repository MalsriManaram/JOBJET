<?php
$page_title = 'Login';
include LAYOUTS.'header.php';
include CONTROLLERS.'Auth/loginController.php';
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/login.css" type="text/css" media="all" />
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card login-card flex-md-row mx-2">
                <div class="row g-0 w-100">
                <!-- Left Side -->
                <div class="col-md-6 col-12 d-flex">
                    <div class="card-body p-4 p-md-5 position-relative ">

                    <!-- Close Button -->
                    <div class="position-absolute  top-0 end-0 p-3">
                        <a href="<?php echo BASE_URL; ?>home" class="btn-close" aria-label="Close"></a>
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
                            <a href="<?php echo BASE_URL; ?>auth/forgot-password" class="form-text text-decoration-none">Forgot Password?</a>
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
                        Don’t have an account? <a href="<?php echo BASE_URL; ?>auth/signup" class="text-decoration-none fw-bold">Sign Up</a>
                        </p>
                    </form>

                    </div>
                </div>
                <!-- Right Side -->
                <div class="col-md-6 d-none d-md-flex p-0" >
                    <img src="<?php echo BASE_URL; ?>assets/images/website-images/LOGIN001.png" alt="Login Image" style="width:450px; height:100%; object-fit:cover;">
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


    </main>

<?php include LAYOUTS.'footer.php'; ?>