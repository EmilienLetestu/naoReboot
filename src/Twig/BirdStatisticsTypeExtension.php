<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 15/11/2017
 * Time: 14:42
 */

namespace App\Twig;


use App\Services\ActivitiesTracker;

class BirdStatisticsTypeExtension extends \Twig_Extension
{
    private $activitiesTracker;

    public function __construct(
        ActivitiesTracker $activitiesTracker
    )
    {
        $this->activitiesTracker = $activitiesTracker;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('statistics',[$this, 'birdStatisticsFilter'])
        ];
    }

    /**
     * @param $birdId
     * @return array
     */
    public function birdStatisticsFilter($birdId)
    {
       $statistics = $this->activitiesTracker
           ->getReportedSpeciesData($birdId);

       return [
           'population'  => $statistics[0],
           'avgByReport' => $statistics[1],
           'bird'        => $statistics[2]
       ];
    }


}
