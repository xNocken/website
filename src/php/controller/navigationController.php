<?php

namespace NavigationController;

class Navigation
{
    public function getAdminNavigations()
    {
        $folders = scandir(getenv('PROJECT_ROOT') . '/src/php/admin/admin/');

        array_splice($folders, 0, 2);

        $folders = array_map(
            function ($item) {
                return trim($item, '.php');
            },
            $folders
        );

        return $folders;
    }

    public function getNavigations()
    {
        include getenv('PROJECT_ROOT') . '/src/php/controller/database.php';

        $sql = '
        SELECT
            *
        FROM
            navigations;';
        $result = $conn->query($sql);

        $naviagtions = [];
        while ($row = $result->fetch_assoc()) {
            $naviagtions[] = $row;
        }

        return $naviagtions;
    }

    public function addNavigation($name, $path, $rank)
    {
        include getenv('PROJECT_ROOT') . '/src/php/controller/database.php';

        $sql = '
        INSERT INTO
            navigations (`name`, `path`, `rank`)
            VALUES (\'' . $conn->real_escape_string($name)
            . '\', \'' . $conn->real_escape_string($path)
            . '\', \'' . $conn->real_escape_string($rank) . '\');';

        if ($rank === '') {
            $sql = '
            INSERT INTO
                navigations (`name`, `path`)
            VALUES (\'' . $conn->real_escape_string($name)
            . '\', \'' . $conn->real_escape_string($path) . '\');';
        }

        if ($conn->query($sql) === false) {
            return $conn->error;
        } else {
            return true;
        }
    }

    public function toggleNavigation($id, $isActive)
    {
        include getenv('PROJECT_ROOT') . '/src/php/controller/database.php';

        $sql = '
        UPDATE
            navigations
        SET
            active=\'' . !$isActive . '\'
        WHERE
            id = \'' . $id . '\';';
        if ($conn->query($sql) === false) {
            return $conn->error;
        } else {
            return true;
        }
    }

    public function deleteNavigation($id)
    {
        include getenv('PROJECT_ROOT') . '/src/php/controller/database.php';

        $sql = '
        DELETE FROM
            navigations
        WHERE
            id = \'' . $id . '\';';
        if ($conn->query($sql) === false) {
            return $conn->error;
        } else {
            return true;
        }
    }
}
