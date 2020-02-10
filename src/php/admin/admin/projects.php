<!DOCTYPE html>
<html>
<head>
    <?php require getenv('PROJECT_ROOT') . '/src/php/snippets/head.php'; ?>
    <title>Navigation - Admin - xNocken</title>
</head>
<body>
   <?php
    Xnocken\Controller\SnippetController::renderAdminHeader();

    $projects = Xnocken\Controller\ProjectsController::getProjects();

    echo $twig->render(
        'projects.twig',
        [
            'projects'    => $projects,
        ]
    );

    require getenv('PROJECT_ROOT') . '/src/php/snippets/scripts.php';
    ?>
</body>
</html>
