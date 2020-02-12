<?php
namespace Xnocken\Controller;

use \DateTime;
use \DateTimeZone;

class SnippetController
{
    public function renderYoutubeVideos()
    {
        global $twig;
        $result = RequestController::getYoutubeVideos();

        $videos = [];

        foreach ($result->items as $video) {
            $date = new DateTime($video->snippet->publishedAt);
            date_timezone_set($date, new DateTimeZone('CET'));
            $videos[] = [
                'title'                  => $video->snippet->title,
                'video_id'               => $video->id->videoId,
                'image'                  => $video->snippet->thumbnails->medium->url,
                'published_at'           => $date->format('d.m.Y'),
                'live_broadcast_content' => $video->snippet->liveBroadcastContent,
            ];
        }

        echo $twig->render('videos.twig', ['videos' => $videos]);
    }

    public static function renderAccount()
    {
        global $twig;
        $userData = UserController::getUserByName($_SESSION['user']);

        $user = [
            'name'            => $userData['username'],
            'rank'            => $userData['rank'],
            'profile_picture' => $userData['profilePicture'],
        ];

        echo $twig->render('account.twig', ['user' => $user]);
    }

    public static function renderHeader()
    {
        global $twig;

        $navigations = NavigationController::getNavigations();
        $userData = [];

        if (isset($_SESSION['user'])) {
            $user = UserController::getUserByName($_SESSION['user']);

            $userData = [
                'name'            => $user['username'],
                'rank'            => $user['rank'],
                'profile_picture' => $user['profilePicture'],
                'lowername'       => $user['namelower'],
            ];
        }

        echo $twig->render(
            'header.twig',
            [
                'user_data'   => $userData,
                'navigations' => $navigations,
            ]
        );
    }

    public static function renderAdminHeader()
    {
        global $twig;

        $navigations = NavigationController::getAdminNavigations();
        $userData = [];

        if (isset($_SESSION['user'])) {
            $user = UserController::getUserByName($_SESSION['user']);

            $userData = [
                'name'            => $user['username'],
                'rank'            => $user['rank'],
                'profile_picture' => $user['profilePicture'],
                'lowername'       => $user['namelower'],
            ];
        }

        echo $twig->render(
            'adminHeader.twig',
            [
                'user_data'   => $userData,
                'navigations' => $navigations,
            ]
        );
    }

    public static function renderProfile($name)
    {
        global $twig;
        $currentUser;

        if (isset($_SESSION['user'])) {
            $currentUser = $_SESSION['user'];
        } else {
            $currentUser = '';
        }

        $userinfo = UserController::getUserByName($name);

        if (isset($userinfo['username'])) {
            $about = str_replace('</div><div>', '<br>', $userinfo['about']);


            $user = [
                'name'            => $userinfo['username'],
                'profile_picture' => $userinfo['profilePicture'],
                'rank'            => $userinfo['rank'],
                'about'           => $userinfo['about'],
                'lowername'       => $userinfo['namelower'],
            ];

            return $twig->render(
                'profile.twig',
                [
                    'user'         => $user,
                    'current_user' => $currentUser,
                ]
            );
        } else {
            return false;
        }
    }

    public static function renderFeedback($projectId)
    {
        global $twig;
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

            return $twig->render(
                'feedback.twig',
                [
                    'project_feedback' => $projectList,
                    'current_user'      => $currentUser,
                    'projectinfo'       => $projectInfo,
                ]
            );
        } else {
            return false;
        }
    }
}
