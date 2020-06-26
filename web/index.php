<?php
namespace Xnocken;

use Xnocken\Controller\SessionController;

$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

global $lang;

require \getenv('PROJECT_ROOT') . '/vendor/autoload.php';

SessionController::createSession();
$userData;

if (isset($_SESSION['user'])) {
    $userData = Controller\UserController::getUserState($_SESSION['user']);
} else {
    $userData = 0;
}

if (isset($userData['banned'])) {
    if ($userData['banned'] == 1) {
        die('Your account was banned :)');
    }

    $_SESSION['rank'] = $userData['rank'];
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
$twig->addExtension(new \Xnocken\Extention\NewExtention());
$twig->addExtension(new \Twig\Extension\DebugExtension());
$twig->addGlobal('user_data', $userData);
$twig->addGlobal('navigations', $navigations);
$twig->addGlobal('adminNavs', $adminNavs);
$twig->addGlobal('lang', $lang);

if (isset($_SESSION['user'])) {
    $twig->addGlobal('current_user', $_SESSION['user']);
}

$request = $_SERVER['REQUEST_URI'];
$request = trim(explode('?', $request)[0], '/');

$fileToLoad ='';

$isAdminCall = strpos($request, 'admin') === 0;
$isAdminApiCall = strpos($request, 'admin/api') === 0;
$isAdmin = (isset($_SESSION['rank']) && (intval($_SESSION['rank']) > 0));
$isProfileCall = strpos($request, 'profile') === 0;
$isFeedbackCall = strpos($request, 'projects/') === 0;
$fileExists = file_exists(\getenv('PROJECT_ROOT')  . '/src/php/pages/' . $request . '.php');
$isTranslationsJsCall = strpos($request, 'dist/translations.js') === 0;
$isApiCall = strpos($request, 'api') === 0;

$fileToLoad = getenv('PROJECT_ROOT')  . '/src/php/pages/' . $request . '.php';

switch ($request) {
case '/':
case '':
case 'index':
    $fileToLoad = getenv('PROJECT_ROOT')  . '/src/php/pages/root.php';
    break;

default:
    if ($isApiCall && $_SERVER['REQUEST_METHOD'] === 'GET') {
        Controller\SnippetController::renderMethodNotAllowed();
        return;
    } elseif ($fileExists) {
        if ($isAdminCall) {
            if (!$isAdmin) {
                $fileToLoad = '';
                Controller\SnippetController::render404();
                return;
            }
        }
    } else if ($isProfileCall) {
        $fileToLoad = getenv('PROJECT_ROOT')  . '/src/php/pages/profile.php';
    } elseif ($isFeedbackCall) {
        $fileToLoad = getenv('PROJECT_ROOT')  . '/src/php/pages/feedback.php';
    } elseif ($isTranslationsJsCall) {
        Controller\TranslationController::javaScriptAction();
        return;
    } else {
        Controller\SnippetController::render404();
        return;
    }
}

if ($fileToLoad) {
    include $fileToLoad;
}
