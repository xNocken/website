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

    public function twigDumper($dump)
    {
        \dump($dump);
    }
}
