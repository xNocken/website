<?php
namespace xnocken;

$name = 'Not logged in';
$rank = 0;
$profilePicture = 'http://placekitten.com/50/50';

if (isset($_SESSION['user'])) {
    $user = User::getUserByName($_SESSION['user']);
    $navigations = Navigation::getAdminNavigations();

    $name = $user['username'];
    $rank = $user['rank'];
    $profilePicture = $user['profilePicture'];
}
?>

<header>
    <div class="container">
        <div class="header">
            <div class="header--navigation">
                <div class="navigation">
                    <div class="navigation--entry">
                        <a href="/admin/">Home</a>
                    </div>
                    <?php foreach ($navigations as $navigation) { ?>
                        <div class="navigation--entry">
                            <a href="/admin/<?php echo $navigation ?>">
                            <?php echo $navigation ?></a>
                        </div>
                    <?php } ?>
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
                        <?php if (isset($_SESSION['user'])) { ?>
                            <a href="/api/login/logout">Logout</a>
                        <?php } else { ?>
                            <a href="/login">Login</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
