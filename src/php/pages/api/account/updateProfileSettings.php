<?php

use Xnocken\Controller\TranslationController;

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    die(TranslationController::translate('error.login'));
}

$user = $_SESSION['user'];
$name = str_replace('&nbsp;', '', trim($_POST['name']));
$about = $_POST['about'];
$data;

if (strlen($name) < 4) {
    $data = [
        'type' => 'error',
        'msg'  => TranslationController::translate('profile.error.name.short'),
    ];
} else if (strlen($name) > 20) {
    $data = [
        'type' => 'error',
        'msg'  => TranslationController::translate('profile.error.name.long')
    ];
} else if (strlen($about) > 500) {
    $data = [
        'type' => 'error',
        'msg'  => TranslationController::translate('profile.error.about.long')
    ];
}

if (isset($data)) {
    die(json_encode($data));
}


if (Xnocken\Controller\UserController::updateProfile($user, $name, $about) === true) {
    $data = [
        'type' => 'success',
        'msg'  => TranslationController::translate('profile.success.update'),
    ];
} else {
    $data = [
        'type' => 'error',
        'msg'  => TranslationController::translate('error.unknown'),
    ];
}

echo json_encode($data);
