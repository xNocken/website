<?php
    use NavigationController\Navigation;

    $frontendNavigations = Navigation::getNavigations();

    $activeText = [
        '<a data-active="0" class="navigations--button navigations--button__add navigation-active-button">Enable</a>',
        '<a data-active="1" class="navigations--button navigations--button__delete navigation-active-button">Disable</a>',
    ]
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include(getenv('PROJECT_ROOT') . '/src/php/snippets/head.php') ?>
        <title>Navigation - Admin - xNocken</title>
    </head>

    <body>
        <?php include(getenv('PROJECT_ROOT') . '/src/php/snippets/adminHeader.php'); ?>

        <div class="content-wrapper container">
            <div class="navigations">
                <div class="navigations--toolbar">
                    <input type="text" class="navigations--toolbar--input" placeholder="Name" id="add-navigation-name">
                    <input type="text" class="navigations--toolbar--input" placeholder="URL" id="add-navigation-path">
                    <input type="number" class="navigations--toolbar--input" placeholder="Rank" id="add-navigation-rank">
                    <a id="add-navigation-button" class="navigations--button navigations--button__add">Add Navigation</a>
                </div>

                <table class="navigations--table">
                    <tr class="navigations--table--row">
                        <th class="navigations--table--row--field">Name</th>
                        <th class="navigations--table--row--field">URL</th>
                        <th class="navigations--table--row--field">Rank</th>
                        <th class="navigations--table--row--field">Active</th>
                        <th class="navigations--table--row--field">Action</th>
                    </tr>

                <?php foreach($frontendNavigations as $navigation) { ?>

                    <tr class="navigations--table--row" data-id="<?php echo $navigation['id'] ?>">
                        <th class="navigations--table--row--field"><?php echo $navigation['name']; ?></th>
                        <th class="navigations--table--row--field"><?php echo $navigation['path']; ?></th>
                        <th class="navigations--table--row--field"><?php echo $navigation['rank']; ?></th>
                        <th class="navigations--table--row--field"><?php echo $activeText[$navigation['active']]; ?></th>
                        <th class="navigations--table--row--field"><a class="navigations--button navigation-delete-button navigations--button__delete">Delete</a></th>
                    </tr>

                <?php } ?>
            </table>
        </div>
    </div>

    <?php include(getenv('PROJECT_ROOT') . '/src/php/snippets/scripts.php') ?>
</body>
</html>
