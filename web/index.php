

<?php
$request = $_SERVER['REQUEST_URI'];
$request = trim(explode('?', $request)[0], '/');

switch ($request) {
case '/':
case '':
    include __DIR__ . '/root.php';
    break;
default:
    if (strpos($request, 'admin') === 0) {
        if (!isset($_SESSION["user"])) {
            include getenv('PROJECT_ROOT') . '/web/login.php';
        } else {
            if ($_SESSION['rank'] < 1) {
                echo 'nö';
                http_response_code(403);
            } else {
                if (strpos($request, 'admin/api') === 0) {
                    include getenv('PROJECT_ROOT') . '/src/php/' . $request . '.php';
                } else {
                    include getenv('PROJECT_ROOT').'/src/php/admin/'.$request.'.php';
                }
            }
        }
    } else {
        if (file_exists(__DIR__  . '/' . $request . '.php')) {
            include __DIR__  . '/' . $request . '.php';
        } else {
            http_response_code(404);
            include __DIR__ . '/404.php';
        }
    }

    break;
}
