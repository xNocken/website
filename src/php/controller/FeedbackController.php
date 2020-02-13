<?php
namespace Xnocken\Controller;

class FeedbackController
{
    public static function defaultAction()
    {
        global $twig;
        $projectId = urldecode(substr(trim($_SERVER['REQUEST_URI'], '/'), 9, 29));
         $currentUser;

        if (isset($_SESSION['user'])) {
            $currentUser = $_SESSION['user'];
        } else {
            $currentUser = '';
        }

        $projectFeedback = FeedbackController::getFeedbackForProject($projectId);
        $projectInfo = ProjectsController::getprojectById($projectId);
        $projectList = [];


        if (isset($projectInfo['name'])) {
            if (isset($projectFeedback['projects'])) {
                foreach ($projectFeedback['projects'] as $i => $project) {
                    $userInfos = $projectFeedback['userlist'][$i];
                    $projectList[] = [
                        'id'              => $project['id'],
                        'message'         => $project['message'],
                        'positive'        => $project['positive'],
                        'username'        => $userInfos['username'],
                        'rank'            => $userInfos['rank'],
                        'banned'          => $userInfos['banned'],
                        'profile_picture' => $userInfos['profilePicture'],
                    ];
                }
            }

            echo $twig->render(
                'feedback.twig',
                [
                    'project_feedback'  => $projectList,
                    'current_user'      => $currentUser,
                    'projectinfo'       => $projectInfo,
                ]
            );
        } else {
            SnippetController::render404();
        }
    }

    public static function addFeedback($user, $message, $positive, $projectId)
    {
        $conn = DatabaseController::startConnection();

        $user = $conn->real_escape_string($user);
        $message = $conn->real_escape_string($message);
        $positive = $conn->real_escape_string($positive);
        $projectId = $conn->real_escape_string($projectId);

        $data = [];

        $sql = 'INSERT INTO
            feedback (`userlower`, `message`, `positive`, `projectId`)
        VALUES
            (\'' . $name . '\', \'' . $message . '\', \'' . $positive . '\', \'' . $projectId . '\')';

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
                'msg'   => 'Successfully posted feedback',
            ];
        }

        return $data;
    }

    public static function removeFeedback($name, $id)
    {
        $conn = DatabaseController::startConnection();
        $name = $conn->real_escape_string($name);
        $id = $conn->real_escape_string($id);

        $sql = 'DELETE FROM
         feedback
            WHERE
        id = \'' . $id .'\' AND userlower = \'' . $name . '\';';

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
                'msg'   => 'Successfully deleted feedback',
            ];
        }

        return $data;
    }

    public static function removeFeedbackAdmin($id)
    {
        $conn = DatabaseController::startConnection();
        $id = $conn->real_escape_string($id);

        $sql = 'DELETE FROM
         feedback
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
                'msg'   => 'Successfully deleted feedback',
            ];
        }

        return $data;
    }

    public static function getFeedbackForProject($projectId)
    {
        $conn = DatabaseController::startConnection();
        $projectId = $conn->real_escape_string($projectId);

        $sql = '
        SELECT
            *
        FROM
            feedback
        WHERE
            projectId = \'' . $projectId . '\';';

        $result = $conn->query($sql);

        $items = [];

        while ($row = $result->fetch_assoc()) {
            $items['projects'][] = $row;
            $items['userlist'][] = UserController::getUserByName($row['userlower']);
        }

        return $items;
    }

    public static function getAllFeedback()
    {
        $conn = DatabaseController::startConnection();
        $sql = '
        SELECT
            *
        FROM
            feedback;';

        $result = $conn->query($sql);

        $items = [];

        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }

        return $items;
    }
}
