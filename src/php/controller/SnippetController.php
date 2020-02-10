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
        $user2;

        if (isset($_SESSION['user'])) {
            $user2 = $_SESSION['user'];
        } else {
            $user2 = '';
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
                    'current_user' => $user2,
                ]
            );
        } else {
            return false;
        }
    }
}
