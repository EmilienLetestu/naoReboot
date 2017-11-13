<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 13/11/2017
 * Time: 09:11
 */

namespace App\Twig;


class UrlCharsTypeExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('specChars',[$this,'urlCharsFilter'])
        ];
    }

    public function urlCharsFilter($name)
    {
        return str_replace('ç','c',$name);
    }
}