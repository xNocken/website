<?php
namespace Xnocken\Controller;

class SessionController
{
    public function createSession()
    {
        if (!isset($_SESSION["user"])) {
            session_start();
        }
    }

    public static function destroySession()
    {
        $data = [];
        if (isset($_SESSION["user"])) {
            session_destroy();

            $data = [
                'type' => 'success',
                'msg'  => 'Logged out',
            ];
        } else {
            $data = [
                'type' => 'error',
                'msg'  => 'There was an unexpected error',
            ];
        }
    }
}
