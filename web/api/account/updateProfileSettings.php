<?php

$name = $_POST['name'];
$user = $_SESSION['user'];

echo json_encode(Xnocken\Controller\UserController::updateProfile($user, $name));
