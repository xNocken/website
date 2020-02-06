<?php
namespace Xnocken;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require getenv('PROJECT_ROOT') . '/src/php/snippets/head.php';  ?>
  <link rel="stylesheet" href="./dist/style.css">
  <title>xNocken</title>
</head>
<body>
    <?php require getenv('PROJECT_ROOT') . '/src/php/snippets/header.php';  ?>

    <div class="content-wrapper">
        <?php echo Controller\SnippetController::renderYoutubeVideos(); ?>
    </div>

    <?php require getenv('PROJECT_ROOT') . '/src/php/snippets/scripts.php';  ?>
</body>

</html>
