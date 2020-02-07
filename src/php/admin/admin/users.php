<?php
namespace Xnocken;

$users = Controller\UserController::getAllUsers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require getenv('PROJECT_ROOT') . '/src/php/snippets/head.php'; ?>
    <title>Users - Admin - xNocken</title>
</head>
<body>
<?php \Xnocken\Controller\SnippetController::renderAdminHeader(); ?>

    <div class="content-wrapper">
    <?php
        echo $twig->render(
            'users.twig',
            [
                'users' => $users,
                'username' => $_SESSION['user']
            ]
        );
        ?>
    </div>

    <?php require getenv('PROJECT_ROOT') . '/src/php/snippets/scripts.php'; ?>
</body>
</html>
