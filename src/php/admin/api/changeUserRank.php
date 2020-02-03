<?php

use UserController\User;

$username = $_POST['username'];
$rank = $_POST['rank'];
if ($_SESSION['rank'] > $rank || $_SESSION['rank'] === '2') {
    echo User::changeRank($username, $rank);
} else {
    echo $_SESSION['rank'] . ' is not high enought to change to '. $rank;
    http_response_code(403);
}
