
<?php


    $page_title= "Change Password";
    include('includes/header.php'); 

    include('config.php');
    $msg = "";

    if (isset($_GET['reset'])){

            if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE code='{$_GET['reset']}'")) > 0){

                if(isset($_POST['submit'])){
                    $Password = mysqli_real_escape_string($conn, md5($_POST['Password']));
                    $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm_password']));

                    if ($Password === $confirm_password){
                        $query = mysqli_query($conn, "UPDATE users SET password='{$Password}', code='' WHERE code='{$_GET['reset']}'");

                        if ($query){
                            header("Location: /JOBJET/PHP/login.php");
                        }
                    } else{
                        $msg = "<div style='font-size: 13px; font-weight: 400; font-family: Poppins, sans-serif; background-color: #f8d7da; border-radius: 5px; color: #000000; border: 1px solid #f5c6cb; padding: 6px 18px ; margin-top: 25px; margin-bottom: -20px; font-family: 'Poppins', sans-serif;'>Password and Confirm Password do not match.</div>";
                    }
                }

            }else{
                $msg = "<div style='font-size: 13px; font-weight: 400; font-family: Poppins, sans-serif; background-color: #f8d7da; border-radius: 5px; color: #000000; border: 1px solid #f5c6cb; padding: 6px 18px ; margin-top: 25px; margin-bottom: -20px; font-family: 'Poppins', sans-serif;'>Reset Link do not match.</div>";
                }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/JOBJET/CSS/forcp1.css" type="text/css" media="all" />

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>

        <div>
            <div class="card-body" id="card" >
            
                <div class="card2" >
                    
                    <form action="" method="post">
                    <a href="index.php"> <img src="/JOBJET/IMAGERS/reject.png" class="img00" alt="exit" > </a>
                    <h5 class= "heading1">Change Password</h5>
                    <?php echo $msg; ?>
                            
                            <div >
                                <label for="Password" class="labels">Password</label>
                                <input type="password" name="Password" class="form-control" id="password" pattern=".{15,}" maxlength="15"  placeholder="Enter Your Password" required >
                                <span class="toggle-password" onclick="togglePasswordVisibility('password')">

                                    <i class="fas fa-eye"></i>
                                </span>  
                            </div>

                            <div class="form-group mb-3">
                            <label for="Password" class="label0">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" id="confirmPassword" pattern=".{15,}" maxlength="15" placeholder="Enter Your Confirm Password" required>
                                <span class="toggle-password1" onclick="togglePasswordVisibility('confirmPassword')">
                                        <i class="fas fa-eye"></i>
                                </span> 
                            </div>
                            
                            <div class="form-gorup">
                                <button type="submit" name="submit" class="btn btn-primary" id="button1" >Change Password</button>
                                <div id="registered" >Back To! <a href="login.php" class="login">Log In</a> </div>
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
    <script src="/JOBJET/JavaScript/jquery.min.js"></script>
    
</body>
</html>
<?php include('includes/footer.php'); ?>