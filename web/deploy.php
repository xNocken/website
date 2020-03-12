<?php

// Forked from https://gist.github.com/1809044
// Available from https://gist.github.com/nichtich/5290675#file-deploy-php

$TITLE   = 'Git Deployment Hamster';
$VERSION = '0.11';

echo <<<EOT
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>$TITLE</title>
</head>
<body style="background-color: #000000; color: #FFFFFF; font-weight: bold; padding: 0 10px;">
<pre>
  o-o    $TITLE
 /\\"/\   v$VERSION
(`=*=')
 ^---^`-.
EOT;

// Check whether client is allowed to trigger an update

$allowed_ips = array(
    '207.97.227.', '50.57.128.', '108.171.174.', '50.57.231.', '204.232.175.', '192.30.252.', '185.199.108.', '140.82.112.', // GitHub
    '195.37.139.','193.174.', // VZG
    '::1', '127.0.0.1' // local
);
$allowed = false;

$headers = apache_request_headers();

if (@$headers["X-Forwarded-For"]) {
    $ips = explode(",",$headers["X-Forwarded-For"]);
    $ip  = $ips[0];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

foreach ($allowed_ips as $allow) {
    if (stripos($ip, $allow) !== false) {
        $allowed = true;
        break;
    }
}

if (!$allowed) {
	header('HTTP/1.1 403 Forbidden');
    echo 'Your ip: ' . $ip;
    exit;
}

flush();

// Actually run the update

$commands = array(
    'git pull',
    'cd .. && composer install',
    'cd .. && composer dump-autoload',
    'yarn',
    'yarn prod',
    'test -e /usr/share/update-notifier/notify-reboot-required && echo "system restart required"',
);


$output = "\n";

$log = "####### ".date('Y-m-d H:i:s'). " #######\n";

foreach($commands AS $command){
    // Run it
    $tmp = shell_exec("$command 2>&1");
    // Output
    $output .= "{$command}: <br>";
    $output .= htmlentities(trim($tmp)) . "\n";
    $output .= '<br><br><br>';

    $log  .= "\$ $command\n".trim($tmp)."\n";

    $log .= "\n";
}

$translationCount = updateTranslations();

$log .= $translationCount . ' translations added';
$output .= $translationCount . ' translations added';

file_put_contents('deploy-log-' . date('Y-m-d_H-i-s') . '.txt', $log, FILE_APPEND);

echo $output;

?>
</pre>
</body>
</html>


<?php
function getTranslations()
{
    $langs = [];

    if (file_exists(getenv('PROJECT_ROOT') . '/example-translations/')) {
        $langs = scandir(getenv('PROJECT_ROOT') . '/example-translations/');
    } else {
        $langs = [];
    }

    array_splice($langs, 0, 2);
    $translations = [];

    foreach ($langs as $lang) {

        $filePath = getenv('PROJECT_ROOT') . '/example-translations/' . $lang;
        if (!file_exists($filePath)) {
            fopen($filePath, 'w+');
        }

        $content = \file_get_contents($filePath, true);

        $content = json_decode($content);

        foreach ($content as $key => $item) {
            $test = [];

            $test['value'] = $item;
            $test['key']  = $key;
            $test['lang'] = str_replace('.json', '', $lang);
            $translations[] = $test;
        }
    }

    return $translations;
}

function addTranslation($lang, $key, $value)
{
    $filePath = getenv('PROJECT_ROOT') . '/translations/' . $lang . '.json';
    if (!file_exists($filePath)) {
        fopen($filePath, 'w+');
    }

    $content = \file_get_contents($filePath);

    $content = json_decode($content, true);

    $content[$key] = $value;

    $content = json_encode($content);

    file_put_contents($filePath, $content);
}

function updateTranslations()
{
    $translations = getTranslations();

    foreach ($translations as $translation) {
        addTranslation($translation['lang'], $translation['key'], $translation['value']);
    }

    return sizeof($translations);
}
?>
