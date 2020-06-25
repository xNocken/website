<?php
use Xnocken\Controller\UserController;

if (!isset($_SESSION['user'])) {
    die('please log in first');
    http_response_code(403);
}

UserController::removeDiscord($_SESSION['user']);
