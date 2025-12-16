<?php

$page_title = 'View Resume';
include LAYOUTS.'header.php';
include CONFIG.'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query0 = "SELECT resume_img FROM workinfo WHERE w_id = $id";
    $result0 = mysqli_query($conn, $query0);
    $row0 = mysqli_fetch_assoc($result0);
    if (!empty($row0['resume_img'])) {
        $resume_img = $row0['resume_img'];
    } else {
        $resume_img = 'upload_resume.png';
    }
}
