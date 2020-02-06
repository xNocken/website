<?php
use Xnocken\Controller\UserController;

$name = $_SESSION['user'];
$email = $_POST['email'];

$hash = md5(trim(strtolower($email)));

UserController::updateProfilePicture($name, $hash);
