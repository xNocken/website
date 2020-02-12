<?php
$projectId = urldecode(substr(trim($_SERVER['REQUEST_URI'], '/'), 9, 29));
$response = Xnocken\Controller\SnippetController::renderFeedback($projectId);

if ($response === false) {
    include __DIR__ . '/404.php';
} else {
    ?>

<!DOCTYPE html>
<html>
<head>
    <?php include getenv('PROJECT_ROOT') . '/src/php/snippets/head.php'; ?>
    <title>Navigation - Admin - xNocken</title>
</head>
<body>
    <?php Xnocken\Controller\SnippetController::renderHeader(); ?>
    <?php echo $response ?>
    <?php include getenv('PROJECT_ROOT') . '/src/php/snippets/scripts.php'; ?>
</body>
</html>

    <?php
} ?>
