<?php 
    
    $page_title= "Login Form";
    include('includes/header.php'); 

    session_start();
    include('config.php');
    $msg = "";
    

    if (isset($_GET['verification'])) {
        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE code='{$_GET['verification']}'")) > 0) {
            $query = mysqli_query($conn, "UPDATE users SET code='' WHERE code='{$_GET['verification']}'");
            
            if ($query) {
                $msg = "<div style='width: 340px; height: 40px; font-size: 13px; font-weight: 400; font-family: Poppins, sans-serif; background-color: #cef1c6; border-radius: 5px; color: #030303; border: 1px solid #c6f5ca;  padding: 9px 12px ; margin-top: 8px; margin-bottom: 5px; font-family: 'Poppins', sans-serif;'>Account verification has been successfully completed.</div>";
            }
        } else {
 
            

            if (isset($_POST['submit'])){
                $Email = mysqli_real_escape_string($conn, ($_POST['Email']));
                $Password = mysqli_real_escape_string($conn, md5(($_POST['Password'])));
        
                $sql = "SELECT * FROM users WHERE email = '{$Email}' AND password = '{$Password}'";
                $result = mysqli_query($conn, $sql);
        
                if(mysqli_num_rows($result) === 1){
                    $row = mysqli_fetch_assoc($result);
                
                    if(empty($row['code'])){
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['first_name'] = $row['first_name'];
                        $_SESSION['last_name'] = $row['last_name'];
                        $_SESSION['nick_name'] = $row['nick_name'];
                
                        $_SESSION['SESSION_EMAIL'] = $Email;
                        $image_sql = "SELECT pro_img FROM users WHERE email = '{$Email}'";
                        $image_result = mysqli_query($conn, $image_sql);
                        $image_row = mysqli_fetch_assoc($image_result);
                
                        if ($image_row && !empty($image_row['pro_img'])) {
                            $_SESSION['pro_img'] = $image_row['pro_img'];
                        } 
                

                    } else {
                        $msg = "<div style='font-size: 13px; font-weight: 400; font-family: Poppins, sans-serif; text-align: center; background-color: #f8d7da; border-radius: 5px; color: #000000; border: 1px solid #f5c6cb; padding: 6px 18px 5px; margin-top: 8px; margin-bottom: 5px; font-family: 'Poppins', sans-serif;'>First verify your account and try again.</div>";
                    }
                } else {
                    $msg = "<div style='font-size: 13px; font-weight: 400; font-family: Poppins, sans-serif; text-align: center; background-color: #f8d7da; border-radius: 5px; color: #000000; border: 1px solid #f5c6cb; padding: 6px 18px 5px; margin-top: 8px; margin-bottom: 5px; font-family: 'Poppins', sans-serif;'>Email or password do not match.</div>";
                }
            }
           
        }
    }

    if (isset($_POST['submit'])){
        $Email = mysqli_real_escape_string($conn, ($_POST['Email']));
        $Password = mysqli_real_escape_string($conn, md5(($_POST['Password'])));

        $sql = "SELECT * FROM users WHERE email = '{$Email}' AND password = '{$Password}'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result)=== 1){
            $row = mysqli_fetch_assoc($result);

            if(empty($row['code'])){
                $_SESSION['email'] = $row['email'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['first_name'] = $row['first_name'];
                $_SESSION['last_name'] = $row['last_name'];
                $_SESSION['nick_name'] = $row['nick_name'];

                $_SESSION['SESSION_EMAIL'] = $Email;
                $image_sql = "SELECT pro_img FROM users WHERE email = '{$Email}'";
                $image_result = mysqli_query($conn, $image_sql);
                $image_row = mysqli_fetch_assoc($image_result);
    
                
                if ($image_row && !empty($image_row['pro_img'])) {
                    $_SESSION['pro_img'] = $image_row['pro_img'];
                } 
                
               
    
                header("Location: /JOBJET/PHP/home.php");
                exit();

            }else{
                $msg = "<div style='font-size: 13px; font-weight: 400; font-family: Poppins, sans-serif; text-align: center; background-color: #f8d7da; border-radius: 5px; color: #000000; border: 1px solid #f5c6cb; padding: 6px 18px 5px; margin-top: 8px; margin-bottom: 5px; font-family: 'Poppins', sans-serif;'>First verify your account and try again.</div>";
            }
        } else{
            $msg = "<div style='font-size: 13px; font-weight: 400; font-family: Poppins, sans-serif; text-align: center; background-color: #f8d7da; border-radius: 5px; color: #000000; border: 1px solid #f5c6cb; padding: 6px 18px 5px; margin-top: 8px; margin-bottom: 5px; font-family: 'Poppins', sans-serif;'>Email or password do not match.</div>";
        }
    }


?>


<html>
    <head> 
    <link href="/JOBJET/CSS/login.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    </head>
    <body>

        <div>
            <div class="card-body" id="card" >
            
                <div class="card2" >
                    
                    <form action="" method="post">
                    <a href="home.php"> <img src="/JOBJET/IMAGERS/reject.png" class="img00" alt="exit" > </a>

                    <?php echo $msg; ?>

                    <h5 class= "heading1">Login</h5>
                    
                            <div>
                                <label for="Email" class="labels">Email</label>
                                <input type="email" class="form-control" name="Email" aria-describedby="emailHelp"  value="<?php if (isset($_POST['submit'])) { echo $Email; } ?>" placeholder="yourname@gmail.com" required>
                            </div>
                            
                            <div >
                            <div id="fpassword" ><a href="forgot-password.php" class="fpassword" >Forgot Password?</a> </div>
                                <label for="Password" class="label0">Password</label>
                                <input type="password" name="Password" class="form-control" id="cPassword" pattern=".{15,}" maxlength="15"  placeholder="Enter Your Password" required>
                                <span class="toggle-password" onclick="togglePasswordVisibility('cPassword')">

                                    <i class="fas fa-eye"></i>
                                </span>  
                            </div>
                            
                            <div class="form-gorup">
                                
                                <button name="submit" type="submit" class="btn btn-primary" id="button1" >Login</button>
                                <div id="registered" >Don’t have an Account? <a href="signup.php" class="login">Sign Up</a> </div>
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