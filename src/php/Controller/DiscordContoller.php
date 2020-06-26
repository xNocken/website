<?php
namespace Xnocken\Controller;

class DiscordController
{
    public function codeAction()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            die();
        }

        $code = json_decode(RequestController::getDiscordAuth($_GET['code']), true);

        $user = json_decode(RequestController::getDiscordUser($code['access_token']), true);

        UserController::updateDiscord($_SESSION['user'], $user['username'], $user['id'], $user['discriminator'], $code['access_token'], $code['refresh_token']);

        header('Location: /backup');
    }

    public function backupAction()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            die();
        }

        $user = UserController::getUserByName($_SESSION['user']);

        if (!isset($user['discord_token'])) {
            header('Location: https://discord.com/oauth2/authorize?client_id=725266180117626903&redirect_uri=http%3A%2F%2Fwebsite.local%2Fverify&response_type=code&scope=identify%20guilds');
        }

        $server = RequestController::getDiscordServer($user['discord_token']);

        if ($server == false) {
            $code = json_decode(RequestController::getDiscordAuthRefresh($user['discord_refreshtoken']), true);

            UserController::updateDiscordToken($_SESSION['user'], $code['access_token']);

            $server = RequestController::getDiscordServer($code['discord_token']);
        }

        $server = \json_decode($server, true);

        $listServer = [];

        foreach ($server as $serv) {
            if ($serv['owner'] || ($serv['permissions'] >> 3) & 1 === 1) {
                $listServer[] = [
                    'name' => $serv['name'],
                    'icon' => $serv['icon'],
                    'id'   => $serv['id'],
                ];
            }
        }

        global $twig;

        echo $twig->render('backup.twig', [
            'servers' => $listServer,
        ]);
    }
}
