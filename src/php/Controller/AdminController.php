<?php
namespace Xnocken\Controller;

use Carbon\Carbon;

class AdminController
{
    public static function defaultAction()
    {
        global $twig;

        $usercount = UserController::getUserCount();
        $feedbackCount = FeedbackController::getFeedbackCount();
        $joinedLastDays = UserController::joinedLastDays(7);
        $joinedLastDaysBefore = UserController::joinedLastDays(7, 7);
        $joinedDifference = $joinedLastDays - $joinedLastDaysBefore;
        $projectCount = ProjectsController::getProjectsCount();

        dump($joinedLastDaysBefore);

        if ($joinedDifference === 0) {
            $joinedClass ="neutral";
        } else if ($joinedDifference < 0) {
            $joinedClass ="negative";
        } else {
            $joinedClass = "positive";
        }

        echo $twig->render('admin/root.twig', [
            'data' => [
                'user_count'       => [
                    'value' => $usercount,
                    'name' => 'stats.usercount'
                ],
                'feedback_count'   => [
                    'value' => $feedbackCount,
                    'name' => 'stats.feedback_count'
                ],
                'projects' => [
                    'value' => $projectCount,
                    'name' => 'stats.project_count'
                ],
                'joined_last_days' => [
                    'value' => $joinedLastDays,
                    'name' => 'stats.lastdays',
                    'difference' => $joinedLastDays - $joinedLastDaysBefore,
                    'joined_class' => $joinedClass
                ]
            ]
        ]);
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
                'users'         => $users,
                'username'      => $_SESSION['user'],
                'can_edit_rank' => $_SESSION['rank'] > 1,
            ]
        );
    }
}
