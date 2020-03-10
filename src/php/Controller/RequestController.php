<?php
namespace Xnocken\Controller;

use \DateTime;

class RequestController
{
    private static function _getNewVideos()
    {
        $results = 6;
        $channelId = 'UCKSa71OIt6TL25f_fqT2qnQ';

        $opts = array(
            'http' => array(
                'method' => "GET",
            )
        );

        $context = stream_context_create($opts);
        $file = file_get_contents(
            'https://www.googleapis.com/youtube/v3/search?channelId=' . $channelId . '&type=video&part=snippet,id&order=date&maxResults=' . $results . '&key='
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
        $file = fopen($filePath, 'r+') or fopen($filePath, 'x+');

        if (file_exists($filePath)) {
            $modTime = filemtime($filePath);
            $changeDate = new DateTime();
            $changeDate->setTime(date("H", $modTime), date("i", $modTime));
            $changeDate->setDate(
                date("Y", $modTime),
                date("m", $modTime),
                date("d", $modTime),
            );
            $now = new DateTime();

            $timeDiff = $changeDate->diff($now);
            $timeDiffDays = $timeDiff->format('%d');
            $timeDiffHours = $timeDiff->format('%h') + ($timeDiffDays * 24);
            $timeDiffMinutes = $timeDiff->format('%i') + ($timeDiffHours * 60);

            if ($timeDiffMinutes > 30) {
                $videos = RequestController::_getNewVideos();
                fwrite($file, $videos);
            } else {
                $videos = fread($file, 10000);

                if (!$videos) {
                    $videos = RequestController::_getNewVideos();
                    fwrite($file, $videos);
                }
            }
        } else {
            $videos = RequestController::_getNewVideos();

            fwrite($file, $videos);
        }

        return json_decode($videos);
    }
}
