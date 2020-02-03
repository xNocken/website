<?php
use RequestController\Request;

$videos = Request::getYoutubeVideos();
?>

<div class="container">
    <h3>Recent Uploads</h3>
    <div class="videos">
        <?php
        if (isset($videos)) {
            foreach ($videos->items as $video) {
                $infos = $video->snippet;
                $date = new DateTime($infos->publishedAt);
                date_timezone_set($date, new DateTimeZone('CET')); ?>
            <div class="videos--video">
                <a class="videos--video--link" target="_blank" rel="noopener noreferrer" href="<?php echo 'https://www.youtube.com/watch?v=' . $video->id->videoId; ?>">
                    <div class="videos--video--image--wrapper">
                        <img class="videos--video--image" src="<?php echo $infos->thumbnails->medium->url; ?>">
                        <p class="videos--video--image--live videos--video--image--live__<?php echo $infos->liveBroadcastContent ?>">LIVE</p>
                    </div>
                    <p class="videos--video--date"><?php echo $date->format('d.m.Y'); ?></p>
                    <p class="videos--video--title"><?php echo $infos->title ?></p>
                </a>
            </div>
        <?php
            }
        } else {
            echo '<p>Error while loading videos</p>';
        }?>
    </div>
</div>
