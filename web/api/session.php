<?php
$servername = getenv('DB_IP');
$username   = getenv('DB_USERNAME');
$password   = getenv('DB_PASSWORD');
$database   = getenv('DB_SCHEMA');

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION["user"])) {
    session_start();
}
