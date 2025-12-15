<?php
$page_title = 'Sign Up';
include LAYOUTS.'header.php';
include SRC.'Controllers/Auth/signupController.php';
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/signup.css" type="text/css" media="all" />
<main>
    <div class="container w-100">
        <div class="row justify-content-center m-1">
            <div class="card signup-card flex-md-row ">
                <div class="row ">
                <!-- Left Side (Image - 50%) -->
                <div class="col-md-4 side-width d-none d-md-flex p-0 m-0">
                <img src="<?php echo BASE_URL; ?>assets/images/website-images/SIGNUP.png" alt="Signup Image" style="width:100%; height:100%; object-fit: cover;">
                </div>


                <!-- Right Side (Form - 50%) -->
                <div class="col-md-4 side-width col-12 d-flex">
                    <div class="card-body p-4 p-md-4 position-relative">                    
                    <!-- Close Button -->
                    <div class="position-absolute top-0 end-0 mt-3 -me-5">
                        <a href="<?php echo BASE_URL; ?>auth/login" class="btn-close" aria-label="Close"></a>
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
                        Already have an account? <a href="<?php echo BASE_URL; ?>auth/login" class="text-decoration-none fw-bold">Log In</a>
                        </p>
                    </form>

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
    
</main>

<?php include LAYOUTS.'footer.php'; ?>