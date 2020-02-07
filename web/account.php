<!DOCTYPE html>
<html>
<head>
    <?php require getenv('PROJECT_ROOT') . '/src/php/snippets/head.php'; ?>
    <title>Navigation - Admin - xNocken</title>
</head>
<body>
<?php \Xnocken\Controller\SnippetController::renderHeader(); ?>

    <?php
    if (!isset($_SESSION['user'])) {
        die('<div class="container content-wrapper">please log in first</div>');
        http_response_code(403);
    } else {
        Xnocken\Controller\SnippetController::renderAccount();
    }
    ?>

    <?php require getenv('PROJECT_ROOT') . '/src/php/snippets/scripts.php'; ?>
</body>
</html>
