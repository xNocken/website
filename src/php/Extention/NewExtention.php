<?php
namespace Xnocken\Extention;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigFilter;
use Xnocken\Controller\TranslationController;

class NewExtention extends \Twig\Extension\AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('removeAttr', [$this, 'removeAttribute']),
            new TwigFilter('trans', [$this, 'trans']),
            new TwigFilter('toHex', [$this, 'toHex']),
            new TwigFilter('emoji', [$this, 'emoji']),
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

    public function toHex($number) {
        return dechex($number);
    }

    public function trans($string, $replace = [])
    {
        return TranslationController::translate($string, $replace);
    }

    public function twigDumper($dump)
    {
        \dump($dump);
    }
}
