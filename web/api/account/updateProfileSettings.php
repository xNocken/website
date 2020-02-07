<?php

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    die('please log in first');
}

$user = $_SESSION['user'];
$name = trim(trim($_POST['name']), '$nbsp;');
$about = $_POST['about'];

if (strlen($name) < 4) {
    echo 'short';
    die();
} else if (strlen($name) > 20) {
    echo 'long';
    die();
}

echo json_encode(
    Xnocken\Controller\UserController::updateProfile(
        $user,
        $name,
        $about,
    )
);
