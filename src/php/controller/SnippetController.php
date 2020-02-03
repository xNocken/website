<?php
namespace xnocken;

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
                'title' => $video->snippet->title,
                'videoId' => $video->id->videoId,
                'image' => $video->snippet->thumbnails->medium->url,
                'publishedAt' => $date->format('d.m.Y'),
                'liveBroadcastContent' => $video->snippet->liveBroadcastContent,
            ];
        }

        echo $twig->render('videos.twig', ['videos' => $videos]);
    }
}
