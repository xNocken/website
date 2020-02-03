<?php
require_once getenv('PROJECT_ROOT') . '/src/php/controller/userController.php';
require_once getenv('PROJECT_ROOT') . '/src/php/controller/session.php';
require_once getenv('PROJECT_ROOT') . '/src/php/controller/navigationController.php';
require_once getenv('PROJECT_ROOT') . '/src/php/controller/requestController.php';
require_once getenv('PROJECT_ROOT') . '/src/php/controller/SnippetController.php';
require_once getenv('PROJECT_ROOT') . '/vendor/autoload.php';


$loader = new \Twig\Loader\FilesystemLoader(getenv('PROJECT_ROOT') . '/src/twig/views');
$twig = new \Twig\Environment($loader, ['debug' => true]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

