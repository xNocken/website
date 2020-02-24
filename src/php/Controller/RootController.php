<?php
namespace Xnocken\Controller;

class RootController
{
    public static function defaultAction()
    {
        global $twig;

        $videos = SnippetController::renderYoutubeVideos();
        echo $twig->render(
            'root.twig',
            [
                'videos' => $videos,
            ]
        );
    }
}
