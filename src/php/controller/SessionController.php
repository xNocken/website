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
}
