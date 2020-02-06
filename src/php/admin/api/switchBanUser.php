<?php
namespace Xnocken;

$username = $_POST['username'];
$isBanned = $_POST['isBanned'];

echo Controller\UserController::switchBan($username, $isBanned);
