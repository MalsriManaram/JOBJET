<?php

$page_title = 'Advertisement';
include LAYOUTS.'header.php';
include CONFIG.'config.php';
$msg = '';

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// Load Composer's autoloader
require VENDOR.'autoload.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM jobadds WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if (isset($_POST['submit'])) {
        $company_mail = mysqli_real_escape_string($conn, $_POST['company_mail']);
        $your_name = mysqli_real_escape_string($conn, $_POST['your_name']);
        $contact_no = mysqli_real_escape_string($conn, $_POST['contact_no']);
        $your_email = mysqli_real_escape_string($conn, $_POST['your_email']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);

        // Handle resume upload
        if (isset($_GET['id'])) {
            $img_name = $_FILES['upload_image']['name'];
            $img_size = $_FILES['upload_image']['size'];
            $tmp_name = $_FILES['upload_image']['tmp_name'];
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $allowed_exs = ['jpg', 'jpeg', 'png'];

            if (in_array($img_ex, $allowed_exs) && $img_size < 3145728) {
                $new_img_name = uniqid('IMG-', true).'.'.$img_ex;
                $img_upload_path = 'assets/storage/uploads/applied-resumes/'.$new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);

                // Insert new image into the database
                $sql_insert_image = 'INSERT INTO appliers (your_name, contact_no, your_email, message, appliers_img) VALUES (?, ?, ?, ?, ?)';
                $stmt_insert_image = mysqli_prepare($conn, $sql_insert_image);
                mysqli_stmt_bind_param($stmt_insert_image, 'sssss', $your_name, $contact_no, $your_email, $message, $new_img_name);
                mysqli_stmt_execute($stmt_insert_image);

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
                    $mail->addAddress($company_mail);

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'JobJet - CV Information - '.$your_name;
                    $mail->Body = '<h1>CV Information</h1>'.
                    '<p><b>Name: </b>'.$your_name.'</p>'.
                    '<p><b>Email: </b>'.$your_email.'</p>'.
                    '<p><b>Message: </b>'.$message.'</p>'.
                    '<p><b>CV: </b></p>'.
                    '<br>';
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                    $mail->addStringAttachment(file_get_contents($img_upload_path), $new_img_name, 'base64', 'image/jpeg');
                    $mail->send();

                    $msg .= "<div class='positive-img-msg'>The Rrespond Sent Successfully!</div>";
                } catch (Exception $e) {
                    $msg = "<div class='negative-img-msg-error'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
                }
            } else {
                $msg .= "<div class='negative-img-msg'>Invalid image format or size.<br> Please upload a valid image (under 3MB).</div>";
            }
        }
    }
}
?>