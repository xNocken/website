<?php
namespace UserController;

class User
{
    public function getUserByName($name)
    {
        require(getenv('PROJECT_ROOT') . '/src/php/controller/database.php');

        $sql = "SELECT * FROM `users` WHERE username = '" . $name . "' LIMIT 1;";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                return $row;
            }
        }
    }

    public function getAllUsers()
    {
        require(getenv('PROJECT_ROOT') . '/src/php/controller/database.php');

        $sql = "SELECT * FROM `users`;";
        $result = $conn->query($sql);

        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        return $users;
    }

    public function getLoginDataByName($name)
    {
        require(getenv('PROJECT_ROOT') . '/src/php/controller/database.php');

        $user = $conn->real_escape_string($name);
        $sql = "SELECT username, password, level, banned FROM `users` WHERE username = '$user' LIMIT 1;";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                return $row;
            }
        }
    }
}
