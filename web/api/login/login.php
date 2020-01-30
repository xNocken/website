<?php
require(getenv('PROJECT_ROOT') . '/web/api/session.php');

$servername = getenv('DB_IP');
$username   = getenv('DB_USERNAME');
$password   = getenv('DB_PASSWORD');
$database   = getenv('DB_SCHEMA');

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}


error_reporting(E_ERROR | E_PARSE);
$data = [];
$user = strtolower($_POST['user']);
$pw = $_POST['pw'];

if (isset($user) && isset($pw)) {
    $user = $conn->real_escape_string($user);
    $sql = "SELECT username, password FROM `users` WHERE username = '$user' LIMIT 1;";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        while ($row = $result->fetch_assoc()) {
            if (password_verify($pw, $row["password"])) {
                $data["type"]     = "success";
                $data["msg"]      = "Logged in";
                $_SESSION["user"] = $row["user"];
            }
        }
    }

    if (!$data) {
        $data["type"] = "error";
        $data["msg"]  = "Wrong Password or Username";
        $data['sql'] = $result->num_rows;
    }
} else {
    $data['msg'] = 'username and password required';
    $data['type'] = 'error';
    http_response_code(400);
}

echo json_encode($data);
