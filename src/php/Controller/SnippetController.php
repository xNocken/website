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

        return $videos;
    }

    public static function render404()
    {
        global $twig;

        http_response_code(404);
        echo $twig->render(
            'error.twig',
            [
                'url' => $_SERVER['REQUEST_URI'],
                'code' => 404,
            ]
        );
    }

    public static function renderMethodNotAllowed()
    {
        global $twig;

        http_response_code(405);
        echo $twig->render(
            'error.twig',
            [
                'url' => $_SERVER['REQUEST_URI'],
                'code' => 405,
            ]
        );
    }
}
