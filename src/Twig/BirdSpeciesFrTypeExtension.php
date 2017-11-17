<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 17/11/2017
 * Time: 07:28
 */

namespace App\Twig;


use App\Entity\Bird;

class BirdSpeciesFrTypeExtension extends \Twig_Extension
{

    public function getFilters()
    {
        return[
            new \Twig_SimpleFilter('speciesFr',[$this, 'birdSpeciesFrFilter'])
        ];
    }

    public function  birdSpeciesFrFilter($speciesFr)
    {
        $bird = new Bird();
        $fr = trim($speciesFr);
        $splitFr = preg_split('/;|,/',$fr);
        $sanitizeFr = preg_split('/\(|\)/',$splitFr[0]);

        return  $sanitizeFr[0] === ''  ? $bird->getSpeciesNameOnly() : $sanitizeFr[0];

    }



}