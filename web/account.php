<!DOCTYPE html>
<html>
<head>
    <?php require getenv('PROJECT_ROOT') . '/src/php/snippets/head.php'; ?>
    <title>Navigation - Admin - xNocken</title>
</head>
<body>
    <?php require getenv('PROJECT_ROOT') . '/src/php/snippets/header.php'; ?>

    <?php Xnocken\Controller\SnippetController::renderAccount(); ?>

    <?php require getenv('PROJECT_ROOT') . '/src/php/snippets/scripts.php'; ?>
</body>
</html>
