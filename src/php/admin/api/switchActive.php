<?php
namespace Xnocken;
$isActive = $_POST['active'];
$id = $_POST['id'];

echo Controller\NavigationController::toggleNavigation($id, $isActive);
