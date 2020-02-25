<?php

$id = $_POST['id'];

if ($_SESSION['rank'] < 1) {
    http_response_code(403);
    die('Unauthorized');
}

echo json_encode(Xnocken\Controller\FeedbackController::removeFeedbackAdmin($id));
