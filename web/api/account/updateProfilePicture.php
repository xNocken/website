<?php
use Xnocken\Controller\UserController;

if (!isset($_SESSION['user'])) {
    die('please log in first');
    http_response_code(403);
}

$name = $_SESSION['user'];
$email = $_POST['email'];

$hash = md5(trim(strtolower($email)));

UserController::updateProfilePicture($name, $hash);
