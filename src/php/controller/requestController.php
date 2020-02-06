<?php
namespace Xnocken\Controller;

use \DateTime;

class RequestController
{
    private static function _getNewVideos()
    {

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

        return $file;
    }

    public static function getYoutubeVideos()
    {
        $videos = '';
        $filePath = getenv('PROJECT_ROOT') . '/cache/recentUploads.json';

        if (file_exists($filePath)) {
            $modTime = filemtime($filePath);
            $changeDate = new DateTime();
            $changeDate->setTime(date("H", $modTime), date("i", $modTime));
            $changeDate->setDate(
                date("Y", $modTime),
                date("m", $modTime),
                date("d", $modTime)
            );
            $now = new DateTime();

            $timeDiff = $changeDate->diff($now);
            $timeDiffDays = $timeDiff->format('%d');
            $timeDiffHours = $timeDiff->format('%h') + ($timeDiffDays * 24);
            $timeDiffMinutes = $timeDiff->format('%i') + ($timeDiffHours * 60);

            if ($timeDiffMinutes > 30) {
                $videos = RequestController::_getNewVideos();
                \file_put_contents($filePath, $videos);
            } else {
                $videos = \file_get_contents($filePath);

                if (!$videos) {
                    $videos = RequestController::_getNewVideos();
                    \file_put_contents($filePath, $videos);
                }
            }
        } else {
            $videos = RequestController::_getNewVideos();

            \file_put_contents($filePath, $videos);
        }

        return json_decode($videos);
    }
}
