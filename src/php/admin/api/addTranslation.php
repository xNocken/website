<?php
namespace Xnocken;

$lang = $_POST['lang'];
$key = $_POST['key'];
$value = $_POST['value'];

if (!isset($lang) || !isset($key) || !isset($value)) {
    http_response_code(400);
    die;
}

$result = Controller\TranslationController::addTranslation($lang, $key, $value);

if ($result !== true) {
    echo '"' . $result . '"';
}
