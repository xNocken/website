<?php

namespace Xnocken\Controller;

class NavigationController
{
    public function getAdminNavigations()
    {
        $folders = scandir(getenv('PROJECT_ROOT') . '/src/php/pages/admin/');

        array_splice($folders, 0, 3);

        $folders = array_map(
            function ($item) {
                return str_replace('.php', '', $item);
            },
            $folders
        );

        return $folders;
    }

    public function getNavigations()
    {
        $conn = \Xnocken\Controller\DatabaseController::startConnection();

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
        $conn = \Xnocken\Controller\DatabaseController::startConnection();

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
        $conn = \Xnocken\Controller\DatabaseController::startConnection();

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
        $conn = \Xnocken\Controller\DatabaseController::startConnection();

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
