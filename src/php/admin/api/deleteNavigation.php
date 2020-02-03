<?php
use NavigationController\Navigation;

$id = $_POST['id'];

echo Navigation::deleteNavigation($id);
