<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 30/11/2017
 * Time: 16:16
 */

namespace App\Twig;


class StringUrlTypeExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('replaceSpace',[$this,'stringUrlFilter'])
        ];
    }

    /**
     * @param $string
     * @return mixed
     */
    public function stringUrlFilter($string)
    {
        return preg_replace('/\s+/', '-',trim(strtolower($string)));
    }
}