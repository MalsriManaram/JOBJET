
<?php
$page_title = 'Change Password';
include LAYOUTS.'header.php';
include CONFIG.'config.php';
$msg = '';

if (isset($_GET['reset'])) {
    $reset_code = $_GET['reset'];
    $stmt = $conn->prepare("SELECT id FROM users WHERE code=? LIMIT 1");
    $stmt->bind_param('s', $reset_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        if (isset($_POST['submit'])) {
            $Password = mysqli_real_escape_string($conn, md5($_POST['Password']));
            $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm_password']));

            if ($Password === $confirm_password) {
                $stmt_update = $conn->prepare("UPDATE users SET password=?, code='' WHERE code=?");
                $stmt_update->bind_param('ss', $Password, $reset_code);
                $query = $stmt_update->execute();

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