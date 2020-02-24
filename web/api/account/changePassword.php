<?php
if (!isset($_SESSION['user'])) {
    die('please log in first');
    http_response_code(403);
}

$current = $_POST['current'];
$pw = $_POST['pw'];
$user = $_SESSION['user'];

echo json_encode(Xnocken\Controller\UserController::changePassword($user, $current, $pw));

