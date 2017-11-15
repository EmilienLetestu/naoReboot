<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 15/11/2017
 * Time: 15:16
 */

namespace App\Twig;


use App\Services\ActivitiesTracker;

class LastReportedTypeExtension extends \Twig_Extension
{
    private $activitiesTracker;

    public function __construct(
        ActivitiesTracker $activitiesTracker
    )
    {
        $this->activitiesTracker = $activitiesTracker;
    }


    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('lastReported', [$this, 'lastReportedFilter'])
        ];
    }

    /**
     * @param $birdId
     * @return array
     */
    public function lastReportedFilter($birdId)
    {
        $lastReported = $this->activitiesTracker
            ->getLastReportedData($birdId);

        return [
            'date'  => $lastReported[0],
            'satNav' =>$lastReported[1]
        ];
    }
}
