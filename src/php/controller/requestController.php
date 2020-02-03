<?php

namespace RequestController;

class Request
{
    public function getYoutubeVideos()
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


        return json_decode($file);
    }
}
