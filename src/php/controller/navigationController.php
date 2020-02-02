<?php

namespace NavigationController;

class Navigation
{
    public function getAdminNavigations()
    {
        $folders = scandir(getenv('PROJECT_ROOT') . '/src/php/admin/admin/');

        array_splice($folders, 0, 2);

        $folders = array_map(function ($item) {
            return trim($item, '.php');
        }, $folders);

        return $folders;
    }

    public function getNavigations()
    {
        require(getenv('PROJECT_ROOT') . '/src/php/controller/database.php');

        $sql = 'SELECT * from navigations;';
        $result = $conn->query($sql);

        $naviagtions = [];
        while ($row = $result->fetch_assoc()) {
            $naviagtions[] = $row;
        }

        return $naviagtions;
    }

    public function addNavigation($name, $path, $rank)
    {
        require(getenv('PROJECT_ROOT') . '/src/php/controller/database.php');

        $sql = 'INSERT INTO navigations (`name`, `path`, `rank`) VALUES (\'' . $conn->real_escape_string($name) . '\', \'' . $conn->real_escape_string($path) . '\', \'' . $conn->real_escape_string($rank) . '\');';
        if ($conn->query($sql) === false) {
            return $conn->error;
        } else {
            return true;
        }
    }

    public function toggleNavigation($id, $isActive)
    {
        require(getenv('PROJECT_ROOT') . '/src/php/controller/database.php');

        $sql = 'UPDATE navigations SET active=\'' . !$isActive . '\' WHERE id = \'' . $id . '\';';
        if ($conn->query($sql) === false) {
            return $conn->error;
        } else {
            return true;
        }
    }

    public function deleteNavigation($id)
    {
        require(getenv('PROJECT_ROOT') . '/src/php/controller/database.php');

        $sql = 'DELETE FROM navigations WHERE id = \'' . $id . '\';';
        if ($conn->query($sql) === false) {
            return $conn->error;
        } else {
            return true;
        }
    }
}
