<?php
use UserController\User;

$users = User::getAllUsers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require getenv('PROJECT_ROOT') . '/src/php/snippets/head.php'; ?>
    <title>Users - Admin - xNocken</title>
</head>
<body>
    <?php require getenv('PROJECT_ROOT') . '/src/php/snippets/adminHeader.php'; ?>

    <div class="content-wrapper">
        <div class="container">
            <div class="users">
                <table class="users--table">
                    <tr class="users--table--row">
                        <th class="users--table--row--field">Username</th>
                        <th class="users--table--row--field">Rank</th>
                        <th class="users--table--row--field">Banned</th>
                        <th class="users--table--row--field">Profile picture</th>
                    </tr>
                    <?php
                    foreach ($users as $row) {
                        $currentUser = $row['username'] === $_SESSION['user'];
                        $DISABLED = '';

                        if ($currentUser) {
                            $DISABLED = ' disabled';
                        } ?>
                        <tr class="users--table--row"
                        data-username="<?php echo $row['username'] ?>">
                            <th class="users--table--row--field">
                            <?php echo $row['username'] ?></th>
                            <th class="users--table--row--field">
                                <select class="users--table--row--field--select
                                users-select"
                                data-selected="<?php echo $row['rank'] ?>"
                                <?php echo $DISABLED; ?>>
                                    <option value="0">User</option>
                                    <option value="1">Moderator</option>
                                    <option value="2">Admin</option>
                                </select>
                            </th>
                            <th class="users--table--row--field">
                                <?php echo $row['banned'] ?></th>
                            <th class="users--table--row--field"><img
                                src="<?php echo $row['profilePicture'] ?>"></th>
                        </tr>
                        <?php
                    } ?>
                </table>
            </div>
        </div>
    </div>

    <?php require getenv('PROJECT_ROOT') . '/src/php/snippets/scripts.php'; ?>
</body>
</html>
