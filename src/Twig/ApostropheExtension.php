<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/11/2017
 * Time: 17:44
 */

namespace App\Twig;


class ApostropheExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('apostrophe',[$this, 'vowelFilter'])
        ];
    }


    /**
     * @param $birdName
     * @return string
     */
    public function vowelFilter($birdName)
    {
        $vowel = ['a','e','i','o','u','y'];

        $bird = str_replace('-',' ',$birdName);


        return in_array(strtolower($bird[0]),$vowel) ? 'd\''.$bird : 'de '.$bird;
    }
}
