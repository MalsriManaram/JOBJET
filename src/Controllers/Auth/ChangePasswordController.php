
<?php
$page_title = 'Change Password';
include LAYOUTS.'header.php';
include CONFIG.'config.php';
$msg = '';

if (isset($_GET['reset'])) {
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE code='{$_GET['reset']}'")) > 0) {
        if (isset($_POST['submit'])) {
            $Password = mysqli_real_escape_string($conn, md5($_POST['Password']));
            $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm_password']));

            if ($Password === $confirm_password) {
                $query = mysqli_query($conn, "UPDATE users SET password='{$Password}', code='' WHERE code='{$_GET['reset']}'");

                if ($query) {
                    header('Location: /JOBJET/PHP/login.php');
                }
            } else {
                $msg = "<div style='font-size: 13px; font-weight: 400; font-family: Poppins, sans-serif; background-color: #f8d7da; border-radius: 5px; color: #000000; border: 1px solid #f5c6cb; padding: 6px 18px ; margin-top: 25px; margin-bottom: -20px; font-family: 'Poppins', sans-serif;'>Password and Confirm Password do not match.</div>";
            }
        }
    } else {
        $msg = "<div style='font-size: 13px; font-weight: 400; font-family: Poppins, sans-serif; background-color: #f8d7da; border-radius: 5px; color: #000000; border: 1px solid #f5c6cb; padding: 6px 18px ; margin-top: 25px; margin-bottom: -20px; font-family: 'Poppins', sans-serif;'>Reset Link do not match.</div>";
    }
}

?>