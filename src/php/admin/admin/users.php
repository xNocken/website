<?php
    use UserController\User;

$users = User::getAllUsers();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include(getenv('PROJECT_ROOT') . '/src/php/snippets/head.php') ?>
    <title>Users - Admin - xNocken</title>
</head>
<body>
    <?php include(getenv('PROJECT_ROOT') . '/src/php/snippets/adminHeader.php'); ?>

    <div class="content-wrapper">
        <div class="container">
            <table>
                <tr>
                    <th>Username</th>
                    <th>Level</th>
                    <th>Banned</th>
                    <th>Profile picture</th>
                </tr>
                <?php
                foreach ($users as $row) {
                    echo '<tr>';
                    echo '<th>' . $row['username'] . '</th>';
                    echo '<th>' . $row['level'] . '</th>';
                    echo '<th>' . $row['banned'] . '</th>';
                    echo '<th><img src="' . $row['profilePicture'] . '"></th>';
                    echo '</tr>';
                }
                ?>
            </table>
        </div>
    </div>

    <?php include(getenv('PROJECT_ROOT') . '/src/php/snippets/scripts.php') ?>
</body>
</html>
