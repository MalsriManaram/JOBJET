<?php

$page_title = 'My Profile';
include LAYOUTS.'header.php';
include LAYOUTS.'navbar.php';
include CONFIG.'config.php';

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

    $query0 = "SELECT * FROM users WHERE id = $id";
    $result0 = mysqli_query($conn, $query0);
    $row0 = mysqli_fetch_assoc($result0);
    if (!empty($row0['pro_img'])) {
        $pro_img = $row0['pro_img'];
    } else {
        $pro_img = 'profile.png';
    }

    $query = "SELECT * FROM profile WHERE p_id = $id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $full_name = !empty($row['full_name']) ? $row['full_name'] : 'Full Name';
    $nick_name = !empty($row['nick_name']) ? $row['nick_name'] : '@NickName';
    $address = !empty($row['address']) ? $row['address'] : 'None';
    $birth_day = !empty($row['birth_day']) ? $row['birth_day'] : 'xx/xx/xxxx';
    $gender = !empty($row['gender']) ? $row['gender'] : 'None';
    $phone_no = !empty($row['phone_no']) ? $row['phone_no'] : 'None';
    $site = !empty($row['site']) ? $row['site'] : 'None';
    $pro_email = !empty($row['pro_email']) ? $row['pro_email'] : 'None';

    $query2 = "SELECT * FROM workinfo WHERE w_id = $id";
    $result2 = mysqli_query($conn, $query2);
    $row2 = mysqli_fetch_assoc($result2);
    $skills_str = !empty($row2['skills']) ? trim($row2['skills'], ' , ') : 'None';
    $skills = explode(',', $skills_str);
    $field = !empty($row2['filed']) ? $row2['filed'] : 'None';
    $field2 = !empty($row2['filed2']) ? $row2['filed2'] : 'None';

    $query3 = "SELECT * FROM workexp WHERE work_id = $id";
    $result3 = mysqli_query($conn, $query3);

    $workexp_data = [];
    while ($row3 = mysqli_fetch_assoc($result3)) {
        $workexp_data[] = $row3;
    }
}
