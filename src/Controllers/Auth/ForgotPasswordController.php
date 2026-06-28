
<?php
$page_title = 'Forgot Password';
include LAYOUTS.'header.php';
include CONFIG.'config.php';

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// Load Composer's autoloader
require VENDOR.'autoload.php';

$msg = '';

if (isset($_POST['submit'])) {
    $Email = mysqli_real_escape_string($conn, $_POST['Email']);
    $code = mysqli_real_escape_string($conn, md5(rand()));

    $stmt = $conn->prepare("SELECT id FROM users WHERE email=? LIMIT 1");
    $stmt->bind_param('s', $Email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $stmt_update = $conn->prepare("UPDATE users SET code=? WHERE email=?");
        $stmt_update->bind_param('ss', $code, $Email);
        $query = $stmt_update->execute();

        if ($query) {
            // this code uses for get the verification link to the email
            echo "<div style='display: none;'>";

            // Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->isSMTP();
                $mail->Host = $_ENV['SMTP_HOST'];
                $mail->SMTPAuth = true;
                $mail->Username = $_ENV['SMTP_USERNAME'];
                $mail->Password = $_ENV['SMTP_PASSWORD'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = $_ENV['SMTP_PORT'];

                // Recipients
                $mail->setFrom($_ENV['SMTP_USERNAME']);
                $mail->addAddress($Email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'JobJet - Password Reset ';
                $mail->Body = 'Hear is the Password Reset link <b><a href="'.BASE_URL.'auth/change-password/?reset='.$code.'">'.BASE_URL.'auth/change-password/?reset='.$code.'</a></b>';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            echo '</div>';
            $msg = "<div style='font-size: 13px; font-weight: 400; font-family: Poppins, sans-serif; background-color: #dad7f8; border-radius: 5px; color: #000000; border: 1px solid #cdc6f5; padding: 6px 18px 5px; margin-top: 25px; margin-bottom: -20px; font-family: 'Poppins', sans-serif;'>We've send a verification link on your email address</div>";
        }
    } else {
        $msg = "<div style='font-size: 13px; font-weight: 400; font-family: Poppins, sans-serif; background-color: #f8d7da; border-radius: 5px; color: #000000; border: 1px solid #f5c6cb; padding: 6px 18px ; margin-top: 25px; margin-bottom: -20px; font-family: 'Poppins', sans-serif;'>$Email - This email address do not found.</div>";
    }
}

?>