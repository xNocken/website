<?php

$id = $_POST['id'];

echo json_encode(Xnocken\Controller\ProjectsController::deleteProject($id));
