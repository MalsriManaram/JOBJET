<?php

$page_title = 'Find People';
include LAYOUTS.'header.php';
include LAYOUTS.'navbar.php';
include CONFIG.'config.php';

// sanitize incoming query
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$search_active = $q !== '';
if ($search_active) {
    $q_esc = mysqli_real_escape_string($conn, $q);
    $sql = "
      SELECT u.id, u.pro_img, u.first_name, u.email, p.full_name, w.filed, p.pro_email
      FROM users u
      LEFT JOIN profile p ON u.id = p.p_id
      LEFT JOIN workinfo w ON u.id = w.w_id
      WHERE
        p.full_name LIKE '%$q_esc%' OR
        u.first_name LIKE '%$q_esc%' OR
        u.email LIKE '%$q_esc%' OR
        w.filed LIKE '%$q_esc%' OR
        p.pro_email LIKE '%$q_esc%'
      ORDER BY p.full_name IS NULL, p.full_name, u.first_name
    ";
    $result = mysqli_query($conn, $sql);
} else {
    $sql = '
      SELECT u.id, u.pro_img, u.first_name, u.email, p.full_name, w.filed, p.pro_email
      FROM users u
      LEFT JOIN profile p ON u.id = p.p_id
      LEFT JOIN workinfo w ON u.id = w.w_id
      ORDER BY p.full_name IS NULL, p.full_name, u.first_name
      LIMIT 60
    ';
    $result = mysqli_query($conn, $sql);
}
?>