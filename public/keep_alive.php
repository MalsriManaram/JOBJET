<?php
// Simple keep-alive script for InfinityFree cron job
$secretToken = 'my_super_secret_key_123'; // Change this to a random string!

// Check if the correct token was passed in the URL
if (!isset($_GET['token']) || $_GET['token'] !== $secretToken) {
    http_response_code(403);
    die('Forbidden - Unauthorized Access');
}

// Returns HTTP 200 OK and current server time.
http_response_code(200);
echo "OK - " . date('Y-m-d H:i:s');