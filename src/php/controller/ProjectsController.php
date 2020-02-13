<?php
namespace Xnocken\Controller;

class ProjectsController
{
    public static function defaultAction()
    {
        global $twig;
        $projects = ProjectsController::getProjects();
        $rank;

        if (isset($_SESSION['rank'])) {
            $rank = $_SESSION['rank'];
        } else {
            $rank = 0;
        }

        echo $twig->render(
            'project-list.twig',
            [
                'projects' => $projects,
                'myrank'   => $rank,
            ]
        );
    }

    public static function addProject($name, $path, $rank)
    {
        $conn = DatabaseController::startConnection();

        $name = $conn->real_escape_string($name);
        $path = $conn->real_escape_string($path);
        $rank = $conn->real_escape_string($rank);

        $data = [];

        $sql = 'INSERT INTO
            projects (`name`, `path`, `rank`)
        VALUES
            (\'' . $name . '\', \'' . $path . '\', \'' . $rank . '\')';

        $result = $conn->query($sql);

        if ($result === false) {
            $data = [
                'type'  => 'error',
                'msg'   => 'Unkown error',
                'error' => $conn->error,
            ];
        } else {
            $data = [
                'type'  => 'success',
                'msg'   => 'Successfully added project',
            ];
        }

        return $data;
    }

    public static function deleteProject($id)
    {
        $conn = DatabaseController::startConnection();
        $id = $conn->real_escape_string($id);

        $sql = 'DELETE FROM
         projects
            WHERE
        id = \'' . $id .'\';';

        $result = $conn->query($sql);

        if ($result === false) {
            $data = [
                'type'  => 'error',
                'msg'   => 'Unkown error',
                'error' => $conn->error,
            ];
        } else {
            $data = [
                'type'  => 'success',
                'msg'   => 'Successfully deleted project',
            ];
        }

        return $data;
    }

    public static function getProjects()
    {
        $conn = DatabaseController::startConnection();

        $sql = '
        SELECT
            *
        FROM
            projects;';

        $result = $conn->query($sql);

        $items = [];

        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }

        return $items;
    }

    public static function getprojectByName($name)
    {
        $conn = DatabaseController::startConnection();
        $name = $conn->real_escape_string($name);

        $sql = '
        SELECT
            *
        FROM
            projects
        WHERE
            name = \'' . $name . '\';';

        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            return $row;
        }

        return $items;
    }

    public static function getprojectById($id)
    {
        $conn = DatabaseController::startConnection();
        $id = $conn->real_escape_string($id);

        $sql = '
        SELECT
            *
        FROM
            projects
        WHERE
            id = \'' . $id . '\';';

        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            return $row;
        }
    }
}
