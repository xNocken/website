<!DOCTYPE html>
<html lang="en">

<head>
    <?php include(getenv('PROJECT_ROOT') . '/src/php/snippets/head.php') ?>
    <title>register - xNocken</title>
</head>

<body>
    <form class="register" id="register-form">
        <h1>Register</h1>
        <p class="register--status" id="register-status"></p>
        <input class="register--username" tabindex="1" name="user" type="text" placeholder="Username"><br>
        <input class="register--password" name="pw" tabindex="2" type="password" placeholder="Password"><br>
        <input class="register--submit" tabindex="0" type="submit"><br>
        <a href="/login/">Already have a account?</a>
    </form>
    <?php include(getenv('PROJECT_ROOT') . '/src/php/snippets/scripts.php') ?>
</body>

</html>
