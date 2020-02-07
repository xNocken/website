<?php

if (!isset($_SESSION['user'])) {
    die('please log in first');
    http_response_code(403);
}

$name = $_POST['name'];
$user = $_SESSION['user'];

echo json_encode(Xnocken\Controller\UserController::updateProfile($user, $name));
