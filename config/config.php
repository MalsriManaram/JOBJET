<?php

$conn = mysqli_connect(
    $_ENV['DB_HOST'] ?? 'localhost',
    $_ENV['DB_USER'] ?? 'root',
    $_ENV['DB_PASS'] ?? '',
    $_ENV['DB_NAME'] ?? 'jobjet'
);

if (!$conn) {
    exit('Connection Failed: '.mysqli_connect_error());
}
