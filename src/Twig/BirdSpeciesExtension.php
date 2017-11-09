<?php

/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/11/2017
 * Time: 12:30
 */
namespace App\Twig;

class BirdSpeciesExtension extends \Twig_Extension
{
    /**
     * Get rid of useless data and only display species name
     * @return array
     */
    public function getFilters()
    {
        return[
            new \Twig_SimpleFilter('species',[$this, 'birdFilter'])
        ];
    }

    /**
     * Split targeting capital letters and return species name
     * @param $speciesLatin
     * @return mixed
     */
    public function birdFilter($speciesLatin){
        $extractSpecies = preg_split('/(?=[A-Z])/',$speciesLatin);

        return $extractSpecies[1];
    }
}
