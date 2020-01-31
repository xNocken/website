<?php
require(getenv('PROJECT_ROOT') . '/web/api/session.php');

if (!isset($_SESSION["user"])) {
    include(getenv('PROJECT_ROOT') . '\web\login.php');
} else {
    if ($_SESSION['level'] < 1) {
        echo 'nö';
    } else {
        echo 'test';
    }
}
