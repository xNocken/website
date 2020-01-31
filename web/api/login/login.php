<?php
require(getenv('PROJECT_ROOT') . '/web/api/session.php');

error_reporting(E_ERROR | E_PARSE);
$data = [];
$user = strtolower($_POST['user']);
$pw = $_POST['pw'];

if (isset($user) && isset($pw)) {
    $user = $conn->real_escape_string($user);
    $sql = "SELECT username, password, level FROM `users` WHERE username = '$user' LIMIT 1;";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        while ($row = $result->fetch_assoc()) {
            if (password_verify($pw, $row["password"])) {
                $data["type"]     = "success";
                $data["msg"]      = "Logged in";
                $_SESSION["user"] = $row["username"];
                $_SESSION['level'] = $row['level'];
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
