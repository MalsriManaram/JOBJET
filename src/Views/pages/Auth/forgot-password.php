<?php
include CONTROLLERS.'Auth/ChangePasswordController.php';
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/forfp.css" type="text/css" media="all" />
<main>
    <div>
        <div class="card-body" id="card" >
            <div class="card2" >
                <form action="" method="post">
                    <a href="<?php echo BASE_URL; ?>auth/login"> 
                        <img src="<?php echo BASE_URL; ?>assets/images/website-images/reject.png" class="img00" alt="exit" > 
                    </a>
                    <h5 class= "heading1">Forgot Password</h5>
                    <?php echo $msg; ?>
                    <div>
                        <label for="Password" class="labels">Email</label>
                        <input type="email" class="form-control" name="Email" placeholder="Enter Your Email" required>
                    </div>

                    <div class="form-gorup">
                        <button type="submit" name="submit" class="btn btn-primary" id="button1" >Send Reset Link</button>
                        <div id="registered" >Back To! <a href="<?php echo BASE_URL; ?>auth/login" class="login">Log In</a> </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
            
    <script>
        function togglePasswordVisibility(fieldId) {
            var passwordField = document.getElementById(fieldId);
            var toggleButton = passwordField.nextElementSibling; 

            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleButton.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                passwordField.type = "password";
                toggleButton.innerHTML = '<i class="fas fa-eye"></i>';
            }
        }
    </script>            
</main>

<?php include LAYOUTS.'footer.php'; ?>