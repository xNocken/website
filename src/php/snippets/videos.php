<?php

use RequestController\Request;

$videos = Request::getYoutubeVideos()->items;
?>

<div class="container">

    <h3>Recent Uploads</h3>
    <div class="videos">
        <?php foreach ($videos as $video) {
            $infos = $video->snippet;
        ?>
            <div class="videos--video">
                <a class="videos--video--link" target="_blank" href="<?php echo 'https://www.youtube.com/watch?v=' . $video->id->videoId; ?>">
                    <img class="videos--video--image" src="<?php echo $infos->thumbnails->high->url; ?>">

                    <p class="videos--video--title"><?php echo $infos->title ?></p>
                </a>
            </div>
        <?php } ?>
    </div>
</div>