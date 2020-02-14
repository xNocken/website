<?php

$isPositive = $_POST['isPositive'];
$message = $_POST['message'];
$projectId = $_POST['projectId'];
$user = $_SESSION['user'];

echo json_encode(Xnocken\Controller\FeedbackController::addFeedback($user, $message, $isPositive, $projectId));
