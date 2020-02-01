<?php
use NavigationController\Navigation;

$name = $_POST['name'];
$path = $_POST['path'];

if (!isset($name) || !isset($path)) {
    http_response_code(400);
    die;
}

$result = Navigation::addNavigation($name, $path);

if ($result !== true) {
    echo '"' . $result . '"';
}
