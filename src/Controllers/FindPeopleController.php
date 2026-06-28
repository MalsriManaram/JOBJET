<?php

$page_title = 'Find People';
include LAYOUTS.'header.php';
include LAYOUTS.'navbar.php';
include CONFIG.'config.php';

// sanitize incoming query
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$search_active = $q !== '';
if ($search_active) {
    $stmt = $conn->prepare("
      SELECT u.id, u.pro_img, u.first_name, u.email, p.full_name, w.filed, p.pro_email
      FROM users u
      LEFT JOIN profile p ON u.id = p.p_id
      LEFT JOIN workinfo w ON u.id = w.w_id
      WHERE
        p.full_name LIKE ? OR
        u.first_name LIKE ? OR
        u.email LIKE ? OR
        w.filed LIKE ? OR
        p.pro_email LIKE ?
      ORDER BY p.full_name IS NULL, p.full_name, u.first_name
    ");
    $like_q = '%' . $q . '%';
    $stmt->bind_param('sssss', $like_q, $like_q, $like_q, $like_q, $like_q);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $stmt = $conn->prepare("
      SELECT u.id, u.pro_img, u.first_name, u.email, p.full_name, w.filed, p.pro_email
      FROM users u
      LEFT JOIN profile p ON u.id = p.p_id
      LEFT JOIN workinfo w ON u.id = w.w_id
      ORDER BY p.full_name IS NULL, p.full_name, u.first_name
      LIMIT 60
    ");
    $stmt->execute();
    $result = $stmt->get_result();
}
?>