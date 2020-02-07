<?php
$user = urldecode(substr(trim($_SERVER['REQUEST_URI'], '/'), 8, 20));
$response = Xnocken\Controller\SnippetController::renderProfile($user);


if ($response === false) {
    include __DIR__ . '/404.php';
} else {
    ?>

<!DOCTYPE html>
<html>
<head>
    <?php include getenv('PROJECT_ROOT') . '/src/php/snippets/head.php'; ?>
<title><?php echo $user; ?> - Profile - xNocken</title>
</head>
<body>
    <?php Xnocken\Controller\SnippetController::renderHeader(); ?>
    <?php
        echo $response;
    ?>
    <?php include getenv('PROJECT_ROOT') . '/src/php/snippets/scripts.php'; ?>
</body>
</html>

    <?php
}
?>
