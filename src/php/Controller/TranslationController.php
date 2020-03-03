<?php
namespace Xnocken\Controller;

class TranslationController
{
    public static function defaultAction()
    {
        global $twig;

        $translations = TranslationController::getTranslations();

        echo $twig->render('/admin/translations.twig', [
            'translations' => $translations,
        ]);
    }

    public static function javaScriptAction()
    {
        global $twig;

        $languages = TranslationController::getLanguages();

        $translations = TranslationController::getTranslations();

        header('Content-Type: application/javascript');
        header('Cache-Control: max-age=100000');

        echo $twig->render('/layout/translations.js.twig', [
            'translations' => $translations,
            'languages'    => $languages,
        ]);
    }

    public static function addTranslation($lang, $key, $value)
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

    public static function removeTranslation($lang, $key)
    {
        $filePath = getenv('PROJECT_ROOT') . '/translations/' . $lang . '.json';
        if (!file_exists($filePath)) {
            fopen($filePath, 'w+');
        }

        $content = \file_get_contents($filePath);

        $content = json_decode($content, true);

        $index = array_search($key, $content);

        $content = \array_splice($content, $index, 1);

        $content = json_encode($content);

        file_put_contents($filePath, $content);
    }


    public static function getTranslations()
    {
        $langs = [];

        if (file_exists(getenv('PROJECT_ROOT') . '/translations/')) {
            $langs = scandir(getenv('PROJECT_ROOT') . '/translations/');
        } else {
            $langs = [];
        }

        array_splice($langs, 0, 2);
        $translations = [];

        foreach ($langs as $lang) {

            $filePath = getenv('PROJECT_ROOT') . '/translations/' . $lang;
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

    public static function getLanguages()
    {
        $langs = scandir(getenv('PROJECT_ROOT') . '/translations/');

        array_splice($langs, 0, 2);

        foreach ($langs as $key =>$lang) {
            $langs[$key] = str_replace('.json', '', $lang);
        }

        return $langs;
    }

    public static function getTranslationsPerLang($lang)
    {
        $filePath = getenv('PROJECT_ROOT') . '/translations/' . $lang . '.json';
        if (!file_exists($filePath)) {
            fopen($filePath, 'w+');
        }

        $content = \file_get_contents($filePath);

        return json_decode($content);
    }
}
