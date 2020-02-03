<?php
namespace xnocken;

class SnippetController
{
    public function renderYoutubeVideos()
    {
        global $twig;
        $videos = RequestController::getYoutubeVideos();

        echo $twig->render('videos.twig', ['videos' => $videos]);
    }
}
