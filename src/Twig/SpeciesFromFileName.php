<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 07/11/2017
 * Time: 13:56
 */

namespace App\Twig;


class SpeciesFromFileName extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('speciesFromFile',[$this, 'birdNameFilter'])
        ];
    }


    /**
     * @param $filename
     * @return mixed
     */
    public function birdNameFilter($filename)
    {
        $firstStep = explode(".",$filename);
        $sndStep   = explode("_",$firstStep[0]);
        $t = array_splice($sndStep,2);
        $thirdStep = implode(',',$t);

        return str_replace(',',' ',$thirdStep);
    }
}

