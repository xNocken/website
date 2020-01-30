<?php
if (!isset($_SESSION['user'])) {
    session_start();
    echo 'new session';
}
