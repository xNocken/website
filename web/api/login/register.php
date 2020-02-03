<?php
require_once getenv('PROJECT_ROOT') . '/src/php/controller/database.php';

error_reporting(E_ERROR | E_PARSE);
$data = [];

if (isset($_POST["user"]) && isset($_POST["pw"])) {
    $user = $_POST["user"];
    $pw = password_hash($_POST["pw"], PASSWORD_DEFAULT);

    $user = $conn->real_escape_string($user);
    $sql = "SELECT username FROM `users` WHERE username = '$user' LIMIT 1;";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $newJsons = [];
        while ($row = $result->fetch_assoc()) {
            $data = [
                'type' => 'error',
                'msg'  => 'Username already exists',
            ];
        }
    } else {
        $sql = '
        INSERT INTO
            users (`username`, `password`, `rank`)
        VALUES
            (\'' . $user . '\', \'' . $pw . '\', '  . 0 . ');';
        if ($conn->query($sql) === false) {
            $data = [
                'type'     => 'error',
                'msg'      => 'Unkown error',
                'sqlError' => $conn->error,
                'sql'      => $sql,
            ];
        } else {
            $data = [
                'type' => 'success',
                'msg'  => 'Registered',
            ];

            $_SESSION["user"] = $user;
        }
    }
    echo json_encode($data);
}
