<?php 

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require 'vendor/autoload.php';

    $page_title= "Sign Up Form";
    include('includes/header.php'); 
    include ('config.php');
    include ('includes/footer.php');

    $msg = "";

    if (isset($_POST['submit'])){

        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $Email = mysqli_real_escape_string($conn, $_POST['Email']);
        $Password = mysqli_real_escape_string($conn, md5($_POST['Password']));
        $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm_password']));
        $code = mysqli_real_escape_string($conn, md5(rand()));
        $identify = mysqli_real_escape_string($conn, rand());
        
                    
        if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$Email}'")) > 0){
           
            $msg = "<div style='font-size: 13px; font-weight: 400; font-family: Poppins, sans-serif; background-color: #f8d7da; border-radius: 5px; color: #000000; border: 1px solid #f5c6cb; padding: 6px 18px 5px; margin-top: 8px; margin-bottom: 5px; font-family: 'Poppins', sans-serif;'> {$Email} - This email address has been already exists.</div>";

        } 
        else{
            
            if ($Password === $confirm_password){
                $sql = "INSERT INTO users (first_name, last_name, email, password, code, identify ) VALUES ('{$first_name}', '{$last_name}', '{$Email}', '{$Password}', '{$code}', '{$identify}')";
                $result = mysqli_query($conn, $sql);

                if($result){
                        //this code uses for get the verification link to the email
                        echo "<div style='display: none;'>";

                                        //Create an instance; passing `true` enables exceptions
                    $mail = new PHPMailer(true);

                    try {
                        //Server settings
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                        $mail->isSMTP();                                            //Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                        $mail->Username   = 'jobjet7878@gmail.com';                     //SMTP username
                        $mail->Password   = 'zxje isdo ulpd orcd';                               //SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                        //Recipients
                        $mail->setFrom('jobjet7878@gmail.com');
                        $mail->addAddress($Email);
                        

                        //Content
                        $mail->isHTML(true);                                  
                        $mail->Subject = 'JobJet - Verification Email ';
                        $mail->Body    = 'Hear is the Verification link <b><a href="http://localhost:8080/JOBJET/PHP/login.php/?verification='.$code.'">http://localhost:8080/JOBJET/PHP/login.php/?verification='.$code.'</a></b>';
                        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                        $mail->send();
                        echo 'Message has been sent';
                     } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                 
                    echo "</div>";
                    $msg = "<div style='font-size: 13px; font-weight: 400; font-family: Poppins, sans-serif; background-color: #dad7f8; border-radius: 5px; color: #000000; border: 1px solid #cdc6f5; padding: 6px 18px 5px; margin-top: 8px; margin-bottom: 5px; font-family: 'Poppins', sans-serif;'>We've send a verification link on your email address</div>";
                }
                else{
                    $msg = "<div style='font-size: 13px; font-weight: 400; font-family: Poppins, sans-serif; background-color: #f8d7da; border-radius: 5px; color: #000000; border: 1px solid #f5c6cb; padding: 6px 18px 5px; margin-top: 8px; margin-bottom: 5px; font-family: 'Poppins', sans-serif;'>Something went wrong. </div>"; 
                }

            }
            else{
                 $msg = "<div style='font-size: 13px; font-weight: 400; font-family: Poppins, sans-serif; background-color: #f8d7da; border-radius: 5px; color: #000000; border: 1px solid #f5c6cb; padding: 6px 18px 5px; margin-top: 8px; margin-bottom: 5px; font-family: 'Poppins', sans-serif;'>Password and Confirm Password do not match</div>";  
            }

        }


    }



?>


<!DOCTYPE html>
<html lang="zxx">
    <head> 
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="Login Form">

       
        
        <link rel="stylesheet" href="/JOBJET/CSS/signup1.css" type="text/css" media="all" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        

    </head>
    <body>
                        <div id="card">
                        
                            <div class="card2" >
                            <a href="login.php"><img src="/JOBJET/IMAGERS/reject.png" class="img01" alt="exit" ></a>
                            <?php echo $msg; ?>
                                <form action="" method="Post">
                                
                                    <h5 class= "heading1">Sign Up</h5>
                                        <div class="form">
                                            <label for="first Name" class="labels">First Name</label>
                                            <input type="text" name="first_name" class="form-control" value="<?php if (isset($_POST['submit'])) { echo $first_name; } ?>" placeholder="Enter Your First Name" required>
                                        </div>

                                        <div >
                                            <label for="last Name" class="labels">Last Name</label>
                                            <input type="text" name="last_name" class="form-control"  value="<?php if (isset($_POST['submit'])) { echo $last_name; } ?>" placeholder="Enter Your Last Name" required>
                                        </div>

                                        <div >
                                            <label for="Email" class="labels">Email</label>
                                            <input type="email" class="form-control" name="Email" aria-describedby="emailHelp"   value="<?php if (isset($_POST['submit'])) { echo $Email; } ?>" placeholder="yourname@gmail.com" required>
                                            
                                        </div>

                                        <div >
                                            <label for="Password" class="labels">Password</label>
                                            <input type="password" name="Password" class="form-control" id="password"  pattern=".{15,}" maxlength="15" placeholder="Enter Your Password" required >
                                            <span class="toggle-password" onclick="togglePasswordVisibility('password')">
                                                
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>

                                        <div>
                                            <label for="Password" class="label0">Confirm Password</label>
                                            <input type="password" name="confirm_password" class="form-control" id="confirmPassword" pattern=".{15,}" maxlength="15" placeholder="Enter Your Confirm Password" required>

                                            <span class="toggle-password1" onclick="togglePasswordVisibility('confirmPassword')">
                                                <i class="fas fa-eye"></i>
                                            </span>

                                            <div id="registered" >Already Registered? <a href="login.php" class="signup">Log In</a> </div>
                                        
                                        </div>

                                        <div >
                                            <button type="submit" name="submit" class="btn btn-primary" id="button1" >Register</button>
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

     <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

     <script src="/JOBJET/JavaScript/jquery.min.js"></script>

    </body>
</html>

<?php include('includes/footer.php'); ?>