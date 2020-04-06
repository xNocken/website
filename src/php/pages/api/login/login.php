<?php
namespace Xnocken;

use Xnocken\Controller\TranslationController;

error_reporting(E_ERROR | E_PARSE);
$data = [];
$user = strtolower($_POST['user']);
$pw = $_POST['pw'];

if (isset($user) && isset($pw)) {
    $userdata = Controller\UserController::getLoginDataByName($user);

    if (password_verify($pw, $userdata["password"])) {
        if ($userdata['banned'] == '1') {
            $data["type"]     = "error";
            $data["msg"]      = TranslationController::translate('login.error.banned', [
                ':reason:' => $userdata['reason'],
            ]);

            session_destroy();
        } else {
            $data["type"]     = "success";
            $data["msg"]      = TranslationController::translate('login.success');
            $_SESSION["user"] = $userdata["namelower"];
            $_SESSION['rank'] = $userdata['rank'];
        }
    } else {
        $data["type"] = "error";
        $data["msg"]  = TranslationController::translate('login.error.invalid_pass');
    }
} else {
    $data['msg'] = TranslationController::translate('login.error.none');
    $data['type'] = 'error';
    http_response_code(400);
}

echo json_encode($data);
