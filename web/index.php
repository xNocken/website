

<?php
$request = $_SERVER['REQUEST_URI'];

$request = trim($request, '/');

switch ($request) {
  case '/':
  case '':
    require __DIR__ . '/root.php';
    break;
  default:
    if (file_exists( __DIR__  . '/' . $request . '.php')) {
      require __DIR__  . '/' . $request . '.php';
    } else {
      http_response_code(404);
      require __DIR__ . '/404.php';
    }
    break;
}
