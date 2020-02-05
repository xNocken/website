<?php
namespace xnocken;

$name = $_POST['name'];
$path = $_POST['path'];
$rank = $_POST['rank'];

if (!isset($name) || !isset($path)) {
    http_response_code(400);
    die;
}

$result = NavigationController::addNavigation($name, $path, $rank);

if ($result !== true) {
    echo '"' . $result . '"';
}
