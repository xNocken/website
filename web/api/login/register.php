<?php
namespace xnocken;

require_once getenv('PROJECT_ROOT') . '/src/php/controller/database.php';

error_reporting(E_ERROR | E_PARSE);
$data = [];

if (isset($_POST["user"]) && isset($_POST["pw"])) {
    $user = $_POST["user"];
    $pw = $_POST['pw'];

    $data = UserController::register($user, $pw);

    echo json_encode($data);
}
