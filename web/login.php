<!DOCTYPE html>
<html lang="en">

<head>
    <?php include(getenv('PROJECT_ROOT') . '/src/php/snippets/head.php') ?>
    <title>Login - xNocken</title>
</head>

<body>
    <form class="login" id="login-form">
        <?php if (trim($_SERVER['REQUEST_URI'], '/') == 'admin'){ ?>
            <p>Login required to continue</p>
        <?php } ?>
        <h1>Login</h1>
        <p class="login--status" id="login-status"></p>
        <input class="login--username" tabindex="1" name="user" type="text" placeholder="Username"><br>
        <input class="login--password" name="pw" tabindex="2" type="password" placeholder="Password"><br>
        <input class="login--submit" tabindex="0" type="submit"><br>
        <a href="/register/">Need a Account?</a>
    </form>
    <?php include(getenv('PROJECT_ROOT') . '/src/php/snippets/scripts.php') ?>
</body>

</html>
