<?php
$page_title= "About Us";
include('includes/header.php'); 
include('config.php');
include('includes/navbar.php'); 
$msg = "";

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

if (isset($_POST['submit'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $Email = mysqli_real_escape_string($conn, $_POST['Email']);
    $Message = mysqli_real_escape_string($conn, $_POST['Message']);

    $mail = new PHPMailer(true);

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // Commented out to remove debug output
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = 'jobjet7878@gmail.com'; //SMTP username
        $mail->Password = 'zxje isdo ulpd orcd'; //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
        $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('jobjet7878@gmail.com');
        $mail->addAddress('malsrimanaram7878@gmail.com');

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'JobJet - Feedback Message';
        $mail->Body = '<h1>Feedback Message</h1>' . '<br>' .'<p ><b>Email: </b></p>'. $Email . '<br>'.'<p ><b>Full Name: </b></p>' . $full_name . '<br>' .'<p ><b>Message: </b></p>'. $Message;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        $msg = "<div class='confirm_msg'>Your Feedback Sent</div>";
    } catch (Exception $e) {
        $msg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="/JOBJET/CSS/contatctus.css">
</head>
<body class='about-page'>
    <section class="contact">
        
        <div class="content">
            <h2>Contact Us</h2>
            <p>Need to find out more details on Job Jet Group or any of our subsidiaries please feel free to contact us through 
                <br>phone, email or simply by filling out the form given below. Our team members will contact you promptly.</p>
        </div>
        <div class="container">
            <div class="contactInfo">
                <div class="box">
                    <div class="icon"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
                    <div class="text">
                        <h3>Address</h3>
                        <p>Colombo,
                        <br>Rathmalana</p>
                    </div>
                </div>
                <div class="box">
                    <div class="icon"><i class="fa fa-phone" aria-hidden="true"></i></div>
                    <div class="text">
                        <h3>Phone</h3>
                        <p>070 2160298 – Anupama
                        <br>071 3588046 – Malshri
                        <br>076 0166307 – Sankesh
                        <br>078 6368630 – Ayodya</p>
                    </div>
                </div>
                <div class="box">
                    <div class="icon"><i class="fa fa-envelope-o" aria-hidden="true"></i></div>
                    <div class="text">
                        <h3>Email</h3>
                        <p>jobjet7878@gmail.com</p>
                    </div>
                </div>
            </div>
            <div class="contactForm">
                <form method="POST" action="">
                    <h2>Send Feedback</h2>
                    <?php echo $msg; ?>
                    <div class="inputbox">
                        <input type="text" name="full_name" required="required">
                        <span>Full Name</span>
                    </div>
                    <div class="inputbox">
                        <input type="email" name="Email" required="required">
                        <span>Email</span>
                    </div>
                    <div class="inputbox">
                        <textarea required="required" name="Message"></textarea>
                        <span>Type your Message.</span>
                    </div>
                    <div class="inputbox">
                        <button class="button_submit" type="submit" name="submit">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>

<footer class="footer">
    <img class="img" src="/JOBJET/IMAGERS/copyright_white.png" alt="Developed by Tech Titans">
</footer>
</html>
