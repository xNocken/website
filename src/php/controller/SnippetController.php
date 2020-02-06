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
}
