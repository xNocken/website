<!DOCTYPE html>
<html lang="en">

<head>
    <?php require getenv('PROJECT_ROOT') . '/src/php/snippets/head.php'; ?>
    <title>Document</title>
</head>

<body>
    <?php require getenv('PROJECT_ROOT') . '/src/php/snippets/header.php'; ?>
    <div class="container content-wrapper">
        <h1>404</h1>
        <h2><?php echo trim($_SERVER['REQUEST_URI'], '/') ?> not found</h2>
    </div>
    <?php require getenv('PROJECT_ROOT') . '/src/php/snippets/scripts.php'; ?>
</body>

</html>
