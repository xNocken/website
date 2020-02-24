<?php
namespace Xnocken\Controller;

class LoginController
{
    public static function loginAction()
    {
        global $twig;

        echo $twig->render('login.twig', [
            'is_logged_in' => isset($_SESSION['user']),
        ]);
    }

    public static function registerAction()
    {
        global $twig;

        echo $twig->render('register.twig', [
            'is_logged_in' => isset($_SESSION['user']),
        ]);
    }
}
