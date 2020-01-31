<?php
require(getenv('PROJECT_ROOT') . '/web/api/session.php');

$name = 'Not logged in';
$level = 0;
$profilePicture = 'http://placekitten.com/50/50';

if (isset($_SESSION['user'])) {
    $sql = "SELECT username, level, profilePicture FROM `users` WHERE username = '" . $_SESSION['user'] . "' LIMIT 1;";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        while ($row = $result->fetch_assoc()) {
            $name = $row["username"];
            $profilePicture = $row['profilePicture'];
            $level = $row['level'];
        }
    }
}
?>

<header>
    <div class="container">
        <div class="header">
            <div class="header--navigation">
                <div class="navigation">
                <!-- TODO: php this -->
                    <div class="navigation--entry">
                        <a href="/dahinten.html">dahinten</a>
                    </div>
                    <div class="navigation--entry">
                        <a href="/dahinten.html">dahinten</a>
                    </div>
                    <div class="navigation--entry">
                        <a href="/dahinten.html">dahinten</a>
                    </div>
                    <div class="navigation--entry">
                        <a href="/dahinten.html">dahinten</a>
                    </div>
                    <div class="navigation--entry">
                        <a href="/dahinten.html">dahinten</a>
                    </div>
                    <div class="navigation--entry">
                        <a href="/dahinten.html">dahinten</a>
                    </div>
                    <div class="navigation--entry">
                        <a href="/dahinten.html">dahinten</a>
                    </div>
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
                        <?php if (isset($_SESSION['user'])){ ?>
                            <a href="api/login/logout">Logout</a>
                        <?php } else { ?>
                            <a href="/login">Login</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
