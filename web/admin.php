<?php
require(getenv('PROJECT_ROOT') . '/web/api/session.php');

if (!isset($_SESSION["user"])) {
    include(getenv('PROJECT_ROOT') . '\web\login.php');
} else {
    echo 'test';
}
