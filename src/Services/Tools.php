<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 26/09/17
 * Time: 13:55
 */

namespace App\Services;




class Tools
{
    /**
     * @param $date
     * @return bool
     * check if generated link as expired
     */
    public function isLinkStillValid($date)
    {
        $today = new \DateTime();
        $dateFromLink = new \DateTime($date);
        $diff = $dateFromLink->diff($today)->days;

        return $diff < 2 ? true : false;
    }

    /**
     * @param $accessLevel
     * @return bool
     */
    public function getUserAccountStatus($accessLevel)
    {
        return $accessLevel === 2;
    }

    /**
     * @param string $birdSpecies
     * @param int $imagePosition
     * @return array
     */
    public function generateDataForHomeImg(string $birdSpecies, int $imagePosition) :array
    {
        return ['watermark' => $birdSpecies,
                'altText'   => "nao recherche: {$birdSpecies}",
                'fileName'  => "naoEvent_{$imagePosition}_{$birdSpecies}"
        ];
    }

    /**
     * @param $birdSpecies
     * @param $birdId
     * @param $userId
     * @return array
     */
    public function generateDataForUserImg($birdSpecies, $birdId, $userId)
    {
        return ['fileName' => uniqid("{$userId}_{$birdId}"),
                'altText'  => "observation de {$birdSpecies} sur NAO.fr"];
    }

    /**
     * @param bool $speciesLatin
     * @param bool $speciesFr
     * @return array
     */
    public function birdWiki($speciesLatin, $speciesFr = false)
    {
        $extractDataLatin = preg_split('#[\(,\)]#',$speciesLatin);
        $extractDataFr    = explode(',',$speciesFr);

        return ['latin'    => trim($extractDataLatin[0]),
                'twitcher' => trim($extractDataLatin[1]),
                'year'     => trim($extractDataLatin[2]),
                'fr'       => trim($extractDataFr[0])
        ];
    }



}