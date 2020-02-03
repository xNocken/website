<?php
namespace xnocken;
$isActive = $_POST['active'];
$id = $_POST['id'];

echo Navigation::toggleNavigation($id, $isActive);
