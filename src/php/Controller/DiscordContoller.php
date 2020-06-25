<?php
namespace Xnocken\Controller;

class DiscordController
{
    public function codeAction()
    {
        if (!isset($_SESSION['user'])) {
            echo 'Please login first';
            die;
        }

        $code = json_decode(RequestController::getDiscordAuth($_GET['code']), true);

        $user = json_decode(RequestController::getDiscordUser($code['access_token']), true);
        $server = json_decode(RequestController::getDiscordServer($code['access_token']), true);

        UserController::updateDiscord($_SESSION['user'], $user['username'], $user['id'], $user['discriminator'], $server, $code['refresh_token']);
    }
}
