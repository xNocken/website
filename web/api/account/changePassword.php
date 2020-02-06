<?php
$current = $_POST['current'];
$pw = $_POST['pw'];
$user = $_SESSION['user'];

echo json_encode(Xnocken\Controller\UserController::changePassword($user, $current, $pw));

