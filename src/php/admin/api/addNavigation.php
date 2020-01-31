<?php
use NavigationController\Navigation;

$name = $_POST['name'];
$path = $_POST['path'];
$active = $_POST['active'];

if (!isset($name) || !isset($path)) {
    http_response_code(400);
    die;
}

$result = Navigation::addNavigation($name, $path, $active);

if ($result !== true) {
    echo '"' . $result . '"';
}
