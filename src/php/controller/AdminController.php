<?php
namespace Xnocken\Controller;

class AdminController
{
    public static function defaultAction()
    {
        global $twig;

        echo $twig->render('admin/root.twig');
    }

    public static function navigationAction()
    {
        global $twig;

        $frontendNavigations = NavigationController::getNavigations();
        echo $twig->render('admin/navigation.twig', ['navigations' => $frontendNavigations]);
    }

    public static function projectsAction()
    {
        global $twig;
        $projects = ProjectsController::getProjects();

        echo $twig->render(
            'admin/projects.twig',
            [
                'projects'    => $projects,
            ]
        );
    }

    public static function usersAction()
    {
        global $twig;
        $users = UserController::getAllUsers();

        echo $twig->render(
            'admin/users.twig',
            [
                'users'    => $users,
                'username' => $_SESSION['user'],
            ]
        );
    }
}
