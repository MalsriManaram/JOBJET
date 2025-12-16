<?php

$page_title = 'Contact Us';
include LAYOUTS.'header.php';
include LAYOUTS.'navbar.php';
include CONFIG.'config.php';

$msg = '';

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// Load Composer's autoloader
require VENDOR.'autoload.php';

if (isset($_POST['submit'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $Email = mysqli_real_escape_string($conn, $_POST['Email']);
    $Message = mysqli_real_escape_string($conn, $_POST['Message']);

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USERNAME']; // SMTP username
        $mail->Password = $_ENV['SMTP_PASSWORD']; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = $_ENV['SMTP_PORT'];

        // Recipients
        $mail->setFrom($_ENV['SMTP_USERNAME']);
        $mail->addAddress('malsrimanaram7878@gmail.com');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'JobJet - Feedback Message';
        $mail->Body = '<h1>Feedback Message</h1><br><p ><b>Email: </b></p>'.$Email.'<br><p ><b>Full Name: </b></p>'.$full_name.'<br><p ><b>Message: </b></p>'.$Message;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        $msg = "<div class='confirm_msg'>Your Feedback Sent Successfully!</div>";
    } catch (Exception $e) {
        $msg = "<div class='confirm_msg' style='background-color: #ffebee; color: #c62828; border: 1px solid #ef9a9a;'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
    }
}
