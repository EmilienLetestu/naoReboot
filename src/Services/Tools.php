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
}