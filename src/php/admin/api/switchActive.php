<?php
namespace xnocken;
$isActive = $_POST['active'];
$id = $_POST['id'];

echo NavigationController::toggleNavigation($id, $isActive);
