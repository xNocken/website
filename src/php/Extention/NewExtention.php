<?php
namespace Xnocken\Extention;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigFilter;

class NewExtention extends \Twig\Extension\AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('removeAttr', [$this, 'removeAttribute']),
            new TwigFilter('trans', [$this, 'trans']),
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('dumper', [$this, 'twigDumper']),
        ];
    }

    public function removeAttribute($string)
    {
        $string = str_replace('onmouseover', '', $string);
        $string = str_replace('onload', '', $string);
        $string = str_replace('onerror', '', $string);
        return $string;
    }

    public function trans($string, $replace = [])
    {
        global $lang;

        $translations;

        if (\file_exists(getenv('PROJECT_ROOT') . '/translations/' . $lang . '.json')) {
            $translations = \json_decode(file_get_contents(\getenv('PROJECT_ROOT') . '/translations/' . $lang . '.json'), true);
        }

        if (\file_exists(\getenv('PROJECT_ROOT') . '/translations/en.json')) {
            $enTranslations = \json_decode(file_get_contents(\getenv('PROJECT_ROOT') . '/translations/en.json'), true);
        } else {
            return $string;
        }

        $word = '';

        if (isset($translations[$string])) {
            $word = $translations[$string];
        } else if (isset($enTranslations[$string])) {
            $word = $enTranslations[$string];
        } else {
            return $string;
        }

        foreach ($replace as $key => $word2) {
            $word = str_replace($key, $word2, $word);
        }

        return $word;
    }

    public function twigDumper($dump)
    {
        \dump($dump);
    }
}
