<?php
$name = $_POST['name'];
$rank = $_POST['rank'];
$path = $_POST['path'];
$desc = $_POST['desc'];
$github = $_POST['github'];

echo json_encode(Xnocken\Controller\ProjectsController::addProject($name, $path, $rank, $desc, $github));
