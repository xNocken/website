<?php
namespace xnocken;

use \DateTime;

class RequestController
{
    private static function _getNewVideos()
    {
        error_reporting(E_ERROR);

        $opts = array(
            'http' => array(
                'method' => "GET",
            )
        );

        $context = stream_context_create($opts);
        $file = file_get_contents(
            'https://www.googleapis.com/youtube/v3/search?channelId=UCKSa71OIt6TL25f_fqT2qnQ&type=video&part=snippet,id&order=date&maxResults=5&key='
            . getenv('YOUTUBE_AUTH_KEY'),
            false,
            $context
        );

        return $context;
    }

    public static function getYoutubeVideos()
    {
        $videos = '';
        $filePath = getenv('PROJECT_ROOT') . '/cache/recentUploads.json';

        if (file_exists($filePath)) {
            $modTime = filemtime($filePath);
            $changeDate = new DateTime();
            $changeDate->setTime(date("H", $modTime), date("i", $modTime));
            $changeDate->setDate(date("Y", $modTime), date("m", $modTime), date("d", $modTime));
            $now = new DateTime();
            $timeDiff = $changeDate->diff($now);

            if ($timeDiff->format('%i') + ($timeDiff->format('%h') * 60)) {
                $videos = _getNewVideos();
                \file_put_contents($filePath, $videos);
            } else {
                $videos = \file_get_contents($filePath);
            }
        } else {
            $videos = RequestController::_getNewVideos();

            \file_put_contents($filePath, $videos);
        }

        return $videos;
    }
}
