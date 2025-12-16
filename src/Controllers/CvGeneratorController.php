<?php

$page_title = 'CV Generator';
include LAYOUTS.'header.php';
include LAYOUTS.'navbar.php';
include CONFIG.'config.php';

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

    $query0 = "SELECT * FROM users WHERE id = $id";
    $result0 = mysqli_query($conn, $query0);
    $row0 = mysqli_fetch_assoc($result0);
    $first_name = !empty($row0['first_name']) ? $row0['first_name'] : '';
    $last_name = !empty($row0['last_name']) ? $row0['last_name'] : '';
    $email = !empty($row0['email']) ? $row0['email'] : '';

    if (!empty($row0['pro_img'])) {
        $pro_img = $row0['pro_img'];
    } else {
        $pro_img = 'profile.png';
    }

    $query = "SELECT * FROM profile WHERE p_id = $id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $full_name = !empty($row['full_name']) ? $row['full_name'] : $first_name.' '.$last_name;
    $address = !empty($row['address']) ? $row['address'] : '';
    $phone_no = !empty($row['phone_no']) ? $row['phone_no'] : '';
    $pro_email = !empty($row['pro_email']) ? $row['pro_email'] : $email;

    $query2 = "SELECT * FROM workinfo WHERE w_id = $id";
    $result2 = mysqli_query($conn, $query2);
    $row2 = mysqli_fetch_assoc($result2);
    $skills = !empty($row2['skills']) ? $row2['skills'] : '';
    $field = !empty($row2['filed']) ? $row2['filed'] : '';
}
