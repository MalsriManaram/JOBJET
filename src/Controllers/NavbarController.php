<?php

session_start();
include CONFIG.'config.php';

$current_page = basename($_SERVER['PHP_SELF']);

$loggedIn = isset($_SESSION['id']);

if ($loggedIn) {
    $id = $_SESSION['id'];
    $check_user = mysqli_query($conn, "SELECT * FROM `users` WHERE `id` = '$id'");
    mysqli_num_rows($check_user);

    // Fetch user profile image
    if ($result_user = mysqli_fetch_assoc($check_user)) {
        $userRow = $result_user;
        $profileImage = 'assets/storage/uploads/profile-pics/'.(!empty($userRow['pro_img']) ? $userRow['pro_img'] : 'profile.png');
    }

    $select_profile = mysqli_query($conn, "SELECT * FROM `profile` WHERE `p_id` = '$id'");
    $select_workinfo = mysqli_query($conn, "SELECT * FROM `workinfo` WHERE `w_id` = '$id'");

    if (mysqli_num_rows($select_profile) == 0 && mysqli_num_rows($select_workinfo) == 0) {
        mysqli_query($conn, "INSERT INTO `profile` (p_id, birth_day, gender) VALUES ('$id','0000-00-00','None')");
        mysqli_query($conn, "INSERT INTO `workinfo` (w_id) VALUES ('$id')");
    }

    if ($conn) {
        $query = "SELECT * FROM profile WHERE p_id = $id";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $nickName = !empty($row['nick_name']) ? $row['nick_name'] : '@NickName';
            $fullName = !empty($row['full_name']) ? $row['full_name'] : ($_SESSION['first_name'] ?? '').' '.($_SESSION['last_name'] ?? '');
            $proEmail = !empty($row['pro_email']) ? $row['pro_email'] : $_SESSION['email'];
        }
    }
}
