<?php

namespace Xnocken;
$username = $_POST['username'];
$rank = $_POST['rank'];
if ($_SESSION['rank'] > $rank || $_SESSION['rank'] === '2') {
    $response = Controller\UserController::changeRank($username, $rank);
    if ($response !== true) {
        http_response_code(500);
        echo $response;
    }
} else {
    echo $_SESSION['rank'] . ' is not high enought to change to '. $rank;
    http_response_code(403);
}
