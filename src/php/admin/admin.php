<!DOCTYPE html>
<html lang="en">
<head>
    <?php require getenv('PROJECT_ROOT') . '/src/php/snippets/head.php'; ?>
    <title>Admin - xNocken</title>
</head>
<body>
    <?php \Xnocken\Controller\SnippetController::renderAdminHeader(); ?>

    <?php require getenv('PROJECT_ROOT') . '/src/php/snippets/scripts.php'; ?>
</body>
</html>
