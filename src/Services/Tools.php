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
     * @return string
     */
    public function generateDataForHomeImg(string $birdSpecies, int $imagePosition) :string
    {
        return 'naoEvent_'.$imagePosition.'_'.$birdSpecies;
    }

    /**
     * @param $birdSpecies
     * @param $userId
     * @return array
     */
    public function generateDataForUserImg($birdSpecies, $userId) :array
    {
        return [ uniqid("{$userId}_"),
                "observation de {$birdSpecies} sur NAO.fr"];
    }

    /**
     * @param bool $speciesLatin
     * @param bool $speciesFr
     * @return array
     */
    public function birdWiki($speciesLatin, $speciesFr = false) :array
    {
        $extractDataLatin = preg_split('#[\(,\)]#',$speciesLatin);
        $extractDataFr    = explode(',',$speciesFr);

        return ['latin'    => trim($extractDataLatin[0]),
                'twitcher' => trim($extractDataLatin[1]),
                'year'     => trim($extractDataLatin[2]),
                'fr'       => trim($extractDataFr[0])
        ];
    }

    /**
     * set default report data based on user accessLevel
     * @param $accessLevel
     * @param $onHold
     * @return array
     */
    public function reportGateways($accessLevel, $onHold) :array
    {
        $gateWays = [
            $validated = $accessLevel < 2 || $onHold == 1 ? false : true,
            $validated === true ? 5 : 0,
            0
        ];

        return $gateWays;
    }

    /**
     * @return array
     */
    public function getTimeElapsed() :array
    {
        $onlineSince = new \DateTime(date('2017-11-01 00:00:00'));
        $today = new \DateTime(date('Y-m-d h:i:s'));
        $diff = $onlineSince->diff($today);

        return ['days'  => $diff->days,
                'months'=> ($diff->format('%Y')*12) + ($diff->format('%m'))
        ];
    }

}

