<?php
use UserController\User;

error_reporting(E_ERROR | E_PARSE);
$data = [];
$user = strtolower($_POST['user']);
$pw = $_POST['pw'];

if (isset($user) && isset($pw)) {
    $userdata = User::getLoginDataByName($user);

    if (password_verify($pw, $userdata["password"])) {
        if ($userdata['banned'] == '1') {
            $data["type"]     = "error";
            $data["msg"]      = "Your account has been banned";

            session_destroy();
        } else {
            $data["type"]     = "success";
            $data["msg"]      = "Logged in";
            $_SESSION["user"] = $userdata["username"];
            $_SESSION['level'] = $userdata['level'];
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
