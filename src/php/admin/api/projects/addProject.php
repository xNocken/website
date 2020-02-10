<?php
$name = $_POST['name'];
$rank = $_POST['rank'];
$path = $_POST['path'];

echo json_encode(Xnocken\Controller\ProjectsController::addProject($name, $path, $rank));
