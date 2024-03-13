
<?php
    $page_title= "Forgot Password";
    include('includes/header.php'); 

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

     //Load Composer's autoloader
     require 'vendor/autoload.php';

    include ('config.php');
    $msg = "";

    if (isset($_POST['submit'])){
        $Email = mysqli_real_escape_string($conn, $_POST['Email']);
        $code = mysqli_real_escape_string($conn, md5(rand()));

        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$Email}'")) > 0){
            $query = mysqli_query($conn, "UPDATE users SET code='{$code}' WHERE email='$Email'");
           
            if ($query){
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
                    $mail->Subject = 'JobJet - Password Reset ';
                    $mail->Body    = 'Hear is the Password Reset link <b><a href="http://localhost:8080/JOBJET/PHP/change-password.php/?reset='.$code.'">http://localhost:8080/JOBJET/PHP/change-password.php/?reset='.$code.'</a></b>';
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    $mail->send();
                    echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            
                echo "</div>";
                $msg = "<div style='font-size: 13px; font-weight: 400; font-family: Poppins, sans-serif; background-color: #dad7f8; border-radius: 5px; color: #000000; border: 1px solid #cdc6f5; padding: 6px 18px 5px; margin-top: 25px; margin-bottom: -20px; font-family: 'Poppins', sans-serif;'>We've send a verification link on your email address</div>";
            
        }

        }else{
            $msg = "<div style='font-size: 13px; font-weight: 400; font-family: Poppins, sans-serif; background-color: #f8d7da; border-radius: 5px; color: #000000; border: 1px solid #f5c6cb; padding: 6px 18px ; margin-top: 25px; margin-bottom: -20px; font-family: 'Poppins', sans-serif;'>$Email - This email address do not found.</div>";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/JOBJET/CSS/forfp1.css" type="text/css" media="all" />

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>

        <div>
            <div class="card-body" id="card" >
            
                <div class="card2" >
                    
                    <form action="" method="post">
                    <a href="login.php"> <img src="/JOBJET/IMAGERS/reject.png" class="img00" alt="exit" > </a>
                    <h5 class= "heading1">Forgot Password</h5>

                    <?php echo $msg; ?>
                    
                            <div>
                            <label for="Password" class="labels">Email</label>
                            <input type="email" class="form-control" name="Email" placeholder="Enter Your Email" required>
                            </div>

                            <div class="form-gorup">
                                <button type="submit" name="submit" class="btn btn-primary" id="button1" >Send Reset Link</button>
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