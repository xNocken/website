<?php
namespace Xnocken;

$data = Controller\SessionController::destroySession();

echo json_encode($data);
