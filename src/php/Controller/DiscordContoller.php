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

        if (empty($user['discord_token'])) {
            header('Location: https://discord.com/oauth2/authorize?client_id=725266180117626903&redirect_uri=http%3A%2F%2Fwebsite.local%2Fverify&response_type=code&scope=identify%20guilds');
        }

        $files = \scandir(getenv('Backup_Dir') . '/data');

        array_splice($files, 0, 2);
        array_splice($files, count($files) - 1, 1);

        $server = RequestController::getDiscordServer($user['discord_token']);

        if ($server == false) {
            $code = json_decode(RequestController::getDiscordAuthRefresh($user['discord_refreshtoken']), true);

            UserController::updateDiscordToken($_SESSION['user'], $code['access_token']);

            $server = RequestController::getDiscordServer($code['discord_token']);
        }

        $server = \json_decode($server, true);

        $listServer = [];

        foreach ($server as $serv) {
            if ($serv['owner'] || ($serv['permissions'] >> 3) & 1 === 1 && in_array($serv['id'], $files)) {
                $icon = '';

                if (empty($serv['icon'])) {
                    $icon = 'https://cdn.discordapp.com/embed/avatars/' . ($serv['id'] % 5) . '.png';
                } else {
                    $icon = 'https://cdn.discordapp.com/icons/' . $serv['id'] . '/' . $serv['icon'] . '.png';
                }

                $listServer[] = [
                    'name' => $serv['name'],
                    'icon' => $icon,
                    'id'   => $serv['id'],
                ];
            }
        }

        global $twig;

        echo $twig->render('backup.twig', [
            'servers' => $listServer,
        ]);
    }

    public static function serverAction()
    {
        $serverId = explode('/', ($_SERVER['REQUEST_URI']))[2];

        $files = \scandir(getenv('Backup_Dir') . '/data');

        array_splice($files, 0, 2);
        array_splice($files, count($files) - 1, 1);

        $user = UserController::getUserByName($_SESSION['user']);

        $server = RequestController::getDiscordServer($user['discord_token']);

        if ($server == false) {
            $code = json_decode(RequestController::getDiscordAuthRefresh($user['discord_refreshtoken']), true);

            UserController::updateDiscordToken($_SESSION['user'], $code['access_token']);

            $server = RequestController::getDiscordServer($code['discord_token']);
        }

        $server = \json_decode($server, true);

        $allowed = false;

        foreach ($server as $serv) {
            if ($serv['id'] == $serverId) {
                if ($serv['owner'] || ($serv['permissions'] >> 3) & 1 === 1 && in_array($serv['id'], $files)) {

                    $allowed = true;
                }
            }
        }

        if (!$allowed) {
            SnippetController::render404();
            return;
        }

        if (explode('/', ($_SERVER['REQUEST_URI']))[3]) {
            DiscordController::channelAction();
            return;
        }


        $settings = json_decode(file_get_contents(getenv('Backup_dir') . '/data/settings.json'));

        $channels = \scandir(getenv('Backup_Dir') . '/data/' . $serverId);

        array_splice($channels, 0, 2);

        foreach ($channels as $key => $channel) {
            $channels[$key] = json_decode(file_get_contents(getenv('Backup_dir') . '/data/' . $serverId . '/' . $channel));
            $channels[$key]->name = substr($channel, 0, strlen($channel) - 5);
        }

        \dump($channels);

        global $twig;

        echo $twig->render('backup-server.twig', [
            'channels' => $channels,
            'serverId' => $serverId,
        ]);
    }

    public static function channelAction()
    {
        $channelId = explode('/', ($_SERVER['REQUEST_URI']))[3];
        $serverId = explode('/', ($_SERVER['REQUEST_URI']))[2];

        $channels = \scandir(getenv('Backup_Dir') . '/data/' . $serverId);

        array_splice($channels, 0, 2);

        foreach ($channels as $key => $channel) {
            $infos = json_decode(file_get_contents(getenv('Backup_dir') . '/data/' . $serverId . '/' . $channel), true);

            if ($infos['id'] == $channelId) {
                $channelInfos = $infos;
                $channelInfos['name'] = substr($channel, 0, strlen($channel) - 5);
            }
        }

        if (empty($channelInfos)) {
            SnippetController::render404();
            return;
        }

        $settings = json_decode(file_get_contents(getenv('Backup_dir') . '/data/settings.json'), true);

        if (!isset($settings['channels'][$channelId])) {
            $indexed = false;
        } else {
            $indexed = $settings['channels'][$channelId];
        }

        global $twig;

        echo $twig->render('backup-channel.twig', [
            'name'     => $channelInfos['name'],
            'id'       => $channelInfos['id'],
            'messages' => $channelInfos['messages'],
            'indexed'  => $indexed,
        ]);
    }
}
