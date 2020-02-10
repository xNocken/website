<?php

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    die('please log in first');
}

$user = $_SESSION['user'];
$name = trim(trim($_POST['name']), '$nbsp;');
$about = $_POST['about'];
$data;

if (strlen($name) < 4) {
    $data = [
        'type' => 'error',
        'msg'  => 'Name is too short'
    ];
} else if (strlen($name) > 20) {
    $data = [
        'type' => 'error',
        'msg'  => 'Name is too long'
    ];
} else if (strlen($about) > 500) {
    $data = [
        'type' => 'error',
        'msg'  => 'About is too long'
    ];
}

if (isset($data)) {
    die(json_encode($data));
}


if (Xnocken\Controller\UserController::updateProfile($user, $name, $about)) {
    $data = [
        'type' => 'success',
        'msg'  => 'Info successfully changed',
    ];
}

echo json_encode($data);
