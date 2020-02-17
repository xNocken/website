<?php


if (isset($_SESSION['user'])) {
    $isPositive = $_POST['isPositive'];
    $message = $_POST['message'];
    $projectId = $_POST['projectId'];
    $user = $_SESSION['user'];

    echo json_encode(Xnocken\Controller\FeedbackController::addFeedback($user, $message, $isPositive, $projectId));
} else {
    $data = [
        'type' => 'error',
        'msg'  => 'Please log in first',
    ];

    echo json_encode($data);
}

