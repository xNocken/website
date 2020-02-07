<?php
namespace Xnocken;

error_reporting(E_ERROR | E_PARSE);
$data = [];
$user = strtolower($_POST['user']);
$pw = $_POST['pw'];

if (isset($user) && isset($pw)) {
    $userdata = Controller\UserController::getLoginDataByName($user);

    if (password_verify($pw, $userdata["password"])) {
        if ($userdata['banned'] == '1') {
            $data["type"]     = "error";
            $data["msg"]      = "Your account has been banned<br>Reason: " . $userdata['reason'];

            session_destroy();
        } else {
            $data["type"]     = "success";
            $data["msg"]      = "Logged in";
            $_SESSION["user"] = $userdata["namelower"];
            $_SESSION['rank'] = $userdata['rank'];
        }
    } else {
        $data["type"] = "error";
        $data["msg"]  = "Wrong Password or Username";
    }
} else {
    $data['msg'] = 'username and password required';
    $data['type'] = 'error';
    http_response_code(400);
}

echo json_encode($data);
