<?php

namespace Xnocken;
$username = $_POST['username'];
$rank = $_POST['rank'];

if ($_SESSION['rank'] < 2) {
    die("your rank is not high enough");
}

$response = Controller\UserController::changeRank($username, $rank);
if ($response !== true) {
    http_response_code(500);
    echo $response;
}
