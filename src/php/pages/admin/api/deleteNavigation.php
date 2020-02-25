<?php
namespace Xnocken;
$id = $_POST['id'];

echo Controller\NavigationController::deleteNavigation($id);
