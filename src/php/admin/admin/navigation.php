<?php
namespace xnocken;
$frontendNavigations = NavigationController::getNavigations();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require getenv('PROJECT_ROOT') . '/src/php/snippets/head.php'; ?>
    <title>Navigation - Admin - xNocken</title>
</head>
<body>

    <?php
        require getenv('PROJECT_ROOT') . '/src/php/snippets/adminHeader.php';
        echo $twig->render('navigation.twig', ['navigations' => $frontendNavigations]);
        require getenv('PROJECT_ROOT') . '/src/php/snippets/scripts.php';
    ?>
</body>
</html>
