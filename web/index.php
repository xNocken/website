<?php
namespace Xnocken;

use Xnocken\Controller\SessionController;

SessionController::createSession();
$banState;

if (isset($_SESSION['user'])) {
    $banState = Controller\UserController::getBanState($_SESSION['user']);
} else {
    $banState = 0;
}

if ($banState) {
    SessionController::destroySession();
    die('error: please reload page');
}

$navigations = Controller\NavigationController::getNavigations();
$adminNavs = Controller\NavigationController::getAdminNavigations();

$userData = [];

if (isset($_SESSION['user'])) {
    $user = Controller\UserController::getUserByName($_SESSION['user']);

    $userData = [
        'name'            => $user['username'],
        'rank'            => $user['rank'],
        'profile_picture' => $user['profilePicture'],
        'lowername'       => $user['namelower'],
    ];
}

$loader = new \Twig\Loader\FilesystemLoader(getenv('PROJECT_ROOT') . '/src/twig/views');
$twig = new \Twig\Environment($loader, ['debug' => true]);
$twig->addExtension(new \Twig\Extension\DebugExtension());
$twig->addGlobal('user_data', $userData);
$twig->addGlobal('navigations', $navigations);
$twig->addGlobal('adminNavs', $adminNavs);

$request = $_SERVER['REQUEST_URI'];
$request = trim(explode('?', $request)[0], '/');

$fileToLoad ='';

$isAdminCall = strpos($request, 'admin') === 0;
$isAdminApiCall = strpos($request, 'admin/api') === 0;
$isAdmin = (isset($_SESSION['rank']) && (intval($_SESSION['rank']) > 0));
$isProfileCall = strpos($request, 'profile') === 0;
$isFeedbackCall = strpos($request, 'projects/') === 0;
$fileExists = file_exists(__DIR__  . '/' . $request . '.php');

switch ($request) {
case '/':
case '':
    $fileToLoad = __DIR__ . '/root.php';
    break;

default:
    if ($fileExists || $isAdminCall || $isProfileCall || $isFeedbackCall) {
        if ($isAdminCall) {
            if ($isAdmin) {
                if ($isAdminApiCall) {
                    $fileToLoad = getenv('PROJECT_ROOT') . '/src/php/' . $request . '.php';
                } else {
                    $fileToLoad = getenv('PROJECT_ROOT').'/src/php/admin/'.$request.'.php';
                }
            } else {
                Controller\SnippetController::render404();
            }
        } elseif ($isProfileCall) {
            $fileToLoad = getenv('PROJECT_ROOT') . '/web/profile.php';
        } elseif ($isFeedbackCall) {
            $fileToLoad = getenv('PROJECT_ROOT') . '/web/feedback.php';
        } else {
            $fileToLoad = __DIR__  . '/' . $request . '.php';
        }
    } else {
        Controller\SnippetController::render404();
    }
}

if ($fileToLoad) {
    include $fileToLoad;
}
