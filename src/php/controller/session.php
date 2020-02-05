<?php
namespace xnocken;

class Session
{
    public function createSession()
    {
        if (!isset($_SESSION["user"])) {
            session_start();
        }
    }
}
