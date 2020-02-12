<!DOCTYPE html>
<html>
<head>
    <?php require getenv('PROJECT_ROOT') . '/src/php/snippets/head.php'; ?>
    <title>Projects - Admin - xNocken</title>
</head>
<body>
    <?php
    Xnocken\Controller\SnippetController::renderHeader();

    $projects = Xnocken\Controller\ProjectsController::getProjects();

    $rank;

    if (isset($_SESSION['rank'])) {
        $rank = $_SESSION['rank'];
    } else {
        $rank = 0;
    }

    echo $twig->render(
        'project-list.twig',
        [
            'projects' => $projects,
            'myrank'   => $rank,
        ]
    );

    require getenv('PROJECT_ROOT') . '/src/php/snippets/scripts.php';
    ?>
</body>
</html>
