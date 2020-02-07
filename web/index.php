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

$loader = new \Twig\Loader\FilesystemLoader(getenv('PROJECT_ROOT') . '/src/twig/views');
$twig = new \Twig\Environment($loader, ['debug' => true]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

$request = $_SERVER['REQUEST_URI'];
$request = trim(explode('?', $request)[0], '/');

$fileToLoad ='';

$isAdminCall = strpos($request, 'admin') === 0;
$isAdminApiCall = strpos($request, 'admin/api') === 0;
$isAdmin = (isset($_SESSION['rank']) && (intval($_SESSION['rank']) > 0));
$isProfileCall = strpos($request, 'profile') === 0;
$fileExists = file_exists(__DIR__  . '/' . $request . '.php');

switch ($request) {
case '/':
case '':
    $fileToLoad = __DIR__ . '/root.php';
    break;

default:
    if ($fileExists || $isAdminCall || $isProfileCall) {
        if ($isAdminCall) {
            if ($isAdmin) {
                if ($isAdminApiCall) {
                    $fileToLoad = getenv('PROJECT_ROOT') . '/src/php/' . $request . '.php';
                } else {
                    $fileToLoad = getenv('PROJECT_ROOT').'/src/php/admin/'.$request.'.php';
                }
            } else {
                $fileToLoad = __DIR__ . '/404.php';
            }
        } else if ($isProfileCall) {
            $fileToLoad = getenv('PROJECT_ROOT') . '/web/profile.php';
        } else {
            $fileToLoad = __DIR__  . '/' . $request . '.php';
        }
    } else {
        http_response_code(404);
        $fileToLoad = __DIR__ . '/404.php';
    }
}

require $fileToLoad;
