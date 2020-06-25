<?php
namespace Xnocken\Controller;

class ProfileController
{
    public static function defaultAction()
    {
        $name = urldecode(substr(trim($_SERVER['REQUEST_URI'], '/'), 8, 20));

        global $twig;
        $currentUser = '';

        if (isset($_SESSION['user'])) {
            $currentUser = $_SESSION['user'];
        } else {
            $currentUser = '';
        }

        $userinfo = UserController::getUserByName($name);

        if (isset($userinfo['username'])) {
            $user = [
                'name'            => $userinfo['username'],
                'profile_picture' => $userinfo['profilePicture'],
                'rank'            => $userinfo['rank'],
                'about'           => $userinfo['about'],
                'lowername'       => $userinfo['namelower'],
                'discordName'     => $userinfo['discord_username'] . '#' . $userinfo['discord_discriminator']
            ];

            echo $twig->render(
                'profile.twig',
                [
                    'user'         => $user,
                    'current_user' => $currentUser,
                ]
            );
        } else {
            SnippetController::render404();
        }
    }
}
