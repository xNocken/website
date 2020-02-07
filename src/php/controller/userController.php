<?php
namespace Xnocken\Controller;

class UserController
{
    public function getUserByName($name)
    {
        $conn = \Xnocken\Controller\DatabaseController::startConnection();
        $sql = "
        SELECT
            *
        FROM
            `users`
        WHERE
            namelower = '" . strtolower($name) . "'
        LIMIT
            1;";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                return $row;
            }
        }
    }

    public function getAllUsers()
    {
        $conn = \Xnocken\Controller\DatabaseController::startConnection();

        $sql = "
        SELECT
            *
        FROM
            `users`;";
        $result = $conn->query($sql);

        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        return $users;
    }

    public function getLoginDataByName($name)
    {
        $conn = \Xnocken\Controller\DatabaseController::startConnection();

        $user = $conn->real_escape_string($name);
        $sql = "
        SELECT
            username,
            password,
            rank,
            banned,
            reason,
            namelower
        FROM
            `users`
        WHERE
            namelower = '" . strtolower($user) . "'
        LIMIT
            1;";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                return $row;
            }
        }
    }

    public function changeRank($name, $rank)
    {
        $conn = \Xnocken\Controller\DatabaseController::startConnection();

        $name = $conn->real_escape_string($name);
        $rank = $conn->real_escape_string($rank);

        $sql = '
        UPDATE
            users
        SET
            rank=\'' . $rank . '\'
        WHERE
            namelower = \'' . strtolower($name) . '\';';
        if (!isset($conn) || $conn->query($sql) === false) {
            return 'ERROR: ' . $conn->error;
        } else {
            return true;
        }
    }

    public function register($user, $pw)
    {
        $conn = \Xnocken\Controller\DatabaseController::startConnection();

        $pw = password_hash($pw, PASSWORD_DEFAULT);
        $user = $conn->real_escape_string($user);

        $sql = "SELECT username FROM `users` WHERE namelower = '" . strtolower($user) . "' LIMIT 1;";
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
            users (`username`, `password`, `rank`, `namelower`)
        VALUES
            (\'' . $user . '\', \'' . $pw . '\', '  . 0 . ', \'' . strtolower($user) . '\');';
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

                $_SESSION["user"] = strtolower($user);
            }
        }

        return $data;
    }

    public static function switchBan($name, $isBanned, $reason)
    {
        $conn = \Xnocken\Controller\DatabaseController::startConnection();

        $sql = '
        UPDATE
            users
        SET
            banned=\'' . !$isBanned . '\',
            reason=\'' . $reason . '\'
        WHERE
            namelower = \'' . strtolower($name) . '\';';

        if ($conn->query($sql) === false) {
            return $conn->error;
        } else {
            return true;
        }
    }

    public static function updateProfilePicture($name, $hash)
    {
        $conn = \Xnocken\Controller\DatabaseController::startConnection();
        $sql = '
        UPDATE
            users
        SET
            profilePicture=\'https://www.gravatar.com/avatar/' . $hash . '?d=mp\'
        WHERE
            namelower = \'' . strtolower($name) . '\';';

        if ($conn->query($sql) === false) {
            return $conn->error;
        } else {
            return true;
        }
    }

    public static function getBanState($name)
    {
        $conn = \Xnocken\Controller\DatabaseController::startConnection();

        $sql = "
        SELECT
            banned
        FROM
            `users`
        WHERE
            namelower = '" . strtolower($name) . "'
        LIMIT
            1;";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                return $row['banned'];
            }
        }
    }

    public static function changePassword($user, $current, $password)
    {
        $conn = \Xnocken\Controller\DatabaseController::startConnection();

        $user = $conn->real_escape_string($user);

        $sql = "SELECT password FROM `users` WHERE namelower = '" . strtolower($user) . "' LIMIT 1;";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $newJsons = [];
            while ($row = $result->fetch_assoc()) {
                if (\password_verify($current, $row['password'])) {
                    $sql = '
                    UPDATE
                        users
                    SET
                        password=\''.\password_hash($password, PASSWORD_DEFAULT).'\'
                    WHERE
                        namelower = \'' . strtolower($user) . '\';';
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
                            'msg'  => 'Password Changed',
                        ];

                        $_SESSION["user"] = strtolower($user);
                    }
                } else {
                    $data = [
                        'type' => 'error',
                        'msg'  => 'Wrong Password',
                    ];
                }
            }
        } else {
            $data = [
                'type' => 'error',
                'msg'  => 'you dont exist lol',
            ];
        }

        return $data;
    }

    public static function updateProfile($user, $name, $about)
    {
        $conn = \Xnocken\Controller\DatabaseController::startConnection();

        $user = $conn->real_escape_string($user);
        $name = $conn->real_escape_string($name);
        $about = $conn->real_escape_string($about);

        $lowerName = strtolower($name);

        $userdata = UserController::getUserByName($lowerName);

        if ($userdata && ($user !== $lowerName)) {
            $data = [
                'type' => 'error',
                'msg'  => 'Username already exists'
            ];

            return $data;
        }

        $sql = '
        UPDATE
            users
        SET
            username=\'' . $name . '\',
            namelower=\'' . $lowerName . '\',
            about=\'' . $about . '\'
        WHERE
            namelower = \'' . strtolower($user) . '\';';
        if (!isset($conn) || $conn->query($sql) === false) {
            return 'ERROR: ' . $conn->error;
        } else {
            $_SESSION['user'] = $lowerName;
            return true;
        }
    }
}
