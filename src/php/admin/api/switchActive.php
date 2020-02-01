<?php
use NavigationController\Navigation;

$isActive = $_POST['active'];
$id = $_POST['id'];

Navigation::toggleNavigation($id, $isActive);
