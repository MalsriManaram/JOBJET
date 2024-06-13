<?php

$page_title = "Advertisement";
include('includes/header.php'); 
include('config.php');
$msg = "";

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

if(isset($_GET['id'])) {
    
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
                if(isset($_GET['id'])) {
                    $img_name = $_FILES['upload_image']['name'];
                    $img_size = $_FILES['upload_image']['size'];
                    $tmp_name = $_FILES['upload_image']['tmp_name'];
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    $allowed_exs = array("jpg", "jpeg", "png");
                
                    if (in_array($img_ex, $allowed_exs) && $img_size < 3145728) {
                        $new_img_name = uniqid("IMG-", true) . '.' . $img_ex;
                        $img_upload_path = 'E:/XAMPP/htdocs/JOBJET/APPLIERS_CV/' . $new_img_name;
                        move_uploaded_file($tmp_name, $img_upload_path);
                
                        // Insert new image into the database
                        $sql_insert_image = "INSERT INTO appliers (your_name, contact_no, your_email, message, appliers_img) VALUES (?, ?, ?, ?, ?)";
                        $stmt_insert_image = mysqli_prepare($conn, $sql_insert_image);
                        mysqli_stmt_bind_param($stmt_insert_image, "sssss", $your_name, $contact_no, $your_email, $message, $new_img_name);
                        mysqli_stmt_execute($stmt_insert_image);

                    
            

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
                            $mail->addAddress($company_mail);

                            //Content
                            $mail->isHTML(true);
                            $mail->Subject = 'JobJet - CV Information - ' . $your_name;
                            $mail->Body = '<h1>CV Information</h1>' .
                            '<p><b>Name: </b>' . $your_name . '</p>' .
                            '<p><b>Email: </b>' . $your_email . '</p>' .
                            '<p><b>Message: </b>' . $message . '</p>' .
                            '<p><b>CV: </b></p>' .
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/JOBJET/CSS/apply_job.css" rel="stylesheet">

</head>
<body>

    <?php if(isset($_GET['id'])): ?> 

        <div class="content">
        <?php echo $msg; ?>
            <button class="apply_button" id="applyBtn">Apply By Email</button>
            <button class="print_button" id="print">Print</button>

            <h3><?= $row['adds_heading']; ?></h3> 

            <img src="/JOBJET/JOBS_IMG/<?= $row['ads_img']; ?>" alt="Ads Image">

            <div class="card">

                <button class="apply_button" id="applyBtn1">Apply By Email</button>
                <button class="print_button" id="print1">Print</button>
            </div>
        </div>
        


        <div class="card2" id="applyForm" >
        <h3>Apply By Email</h3>
            
            <form action="" form method="POST" enctype="multipart/form-data" id="emailForm">
        
                

                    <label for="Company Email" class="labels">Company Email:</label>
                    <input type="text" name="company_mail" class="form-control" id="form-control_e" value="<?php if (isset($_POST['submit'])) { echo $company_mail; } ?>" placeholder="Enter The Company Name"  required>

                    <label for="your Name" class="labels">Your Name:</label>
                    <input type="text" name="your_name" class="form-control"  value="<?php if (isset($_POST['submit'])) { echo $your_name; } ?>" placeholder="Enter Your Name" required>
                
                    <label for="Contact No" class="labels" id="lable02">Contact No:</label>
                    <input type="tel" name="contact_no" class="form-control" id="form-control_c"  value="<?php if (isset($_POST['submit'])) { echo $contact_no; } ?>" maxlength="10" placeholder="Enter Your Last Name" required>

                    <label for="Your Email" class="labels" id="lable03">Your Email:</label>
                    <input type="email" class="form-control" name="your_email" id="form-control_ye" aria-describedby="emailHelp"   value="<?php if (isset($_POST['submit'])) { echo $your_email; } ?>" placeholder="Enter Your Email" required>

                    <label for="Message" class="labels" id="lable04">Message:</label>
                    <textarea class="form-control" id="form-control_me" name="message" placeholder="Enter Your Message" wrap="hard" maxlength="10000" value="<?php if (isset($_POST['submit'])) { echo $message; } ?>"></textarea>
                    
                    <div class="resume">
 
                        <div class="For-infor">

                            <div>
                                <label for="input-file" class="labels">Attach Your CV:</label>
                                <input type="file" id="input-file" class="upload-input" name="upload_image" required>
                                <span class="negative-img-msg-file" id="file-name"></span>
                            </div>

                            <label for="input-file" class="upload-label">
                                <img src="/JOBJET/IMAGERS/uploadimg.png" class="uploading-img" alt="">
                            </label>

                            <div>
                                <button type="submit" name="submit" class="btn btn-primary" id="button1" >Send</button>
                            </div>
                        </div>
                    </div>
            </form>
        </div>

    <?php endif; ?>


    <script>

        const applyBtn = document.getElementById('applyBtn');
        const applyBtn1 = document.getElementById('applyBtn1');
        const applyForm = document.getElementById('applyForm');
            

        function toggleApplyForm() {
            if (applyForm.style.display === 'none' || !applyForm.style.display) {
                applyForm.style.display = 'block';
                applyForm.scrollIntoView({ behavior: 'smooth' });
                
            } else {
                applyForm.style.display = 'none';
            }
        }

        applyBtn.addEventListener('click', toggleApplyForm);
        applyBtn1.addEventListener('click', toggleApplyForm);


        //for the print function 
        const printBtn = document.getElementById('print');
        const printBtn1 = document.getElementById('print1');

        function toggleApplyForm1() {
            window.print();
        };

        printBtn.addEventListener('click',toggleApplyForm1);
        printBtn1.addEventListener('click',toggleApplyForm1);

        //for the css
        applyBtn1.classList.add('buttonJs');
        printBtn1.classList.add('buttonJs');

        //for the upload file name 
        const inputFile = document.getElementById('input-file');
        const fileNameSpan = document.getElementById('file-name');

        inputFile.addEventListener('change', () => {
            const fileName = inputFile.files[0].name;
            fileNameSpan.textContent = `Uploaded file: ${fileName}`;

        });
    </script>

</body>
</html>


<?php include('includes/footer.php'); ?>