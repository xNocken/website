<?php
namespace Xnocken;

$username = $_POST['username'];
$isBanned = $_POST['isBanned'];
$reason = $_POST['reason'];

echo Controller\UserController::switchBan($username, $isBanned, $reason);
