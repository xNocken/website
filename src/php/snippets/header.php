<?php

use UserController\User;
use NavigationController\Navigation;

$navigations = Navigation::getNavigations();

$name = 'Not logged in';
$level = 0;
$profilePicture = '';

if (isset($_SESSION['user'])) {
    $user = User::getUserByName($_SESSION['user']);

    $name = $user['username'];
    $level = $user['level'];
    $profilePicture = $user['profilePicture'];
}
?>

<header>
    <div class="container">
        <div class="header">
            <div class="header--navigation">
                <div class="navigation">
                    <?php foreach($navigations as $navigation) {
                            if ($navigation['active'] === '1' && $navigation['rank'] <= $_SESSION['level']) {
                        ?>
                        <div class="navigation--entry">
                            <a href="<?php echo $navigation['path'] ?>"><?php echo $navigation['name'] ?></a>
                        </div>
                    <?php   }
                        } ?>
                </div>
            </div>

            <div class="header--user">
                <div class="user">
                    <div class="user--name">
                        <?php echo $name; ?>
                    </div>

                    <div class="user--image">
                        <img src="<?php echo $profilePicture; ?>">
                    </div>

                    <div class="user--dropdown">
                        <ul>
                            <?php if (isset($_SESSION['user'])){ ?>
                                <li><a href="/api/login/logout">Logout</a></li>

                            <?php if ($level > 0) { ?>
                                        <li><a href="/admin">Backend</a></li>
                                    <?php }} else { ?>
                                <li><a href="/login">Login</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
