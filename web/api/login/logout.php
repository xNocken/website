<?php
namespace xnocken;

$data = [];


if (isset($_SESSION["user"])) {
    session_destroy();

    $data = [
        'type' => 'success',
        'msg'  => 'Logged out',
    ];
} else {
    $data = [
        'type' => 'error',
        'msg'  => 'There was an unexpected error',
    ];
}

echo json_encode($data);
