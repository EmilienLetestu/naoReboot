<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 15/11/2017
 * Time: 13:05
 */

namespace App\Twig;


use App\Services\ActivitiesTracker;

class ActivitiesTypeExtension extends \Twig_Extension
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
            new \Twig_SimpleFilter('activities',[$this,'activitiesFilter'])
        ];
    }

    /**
     * @param $reportList
     * @return array
     */
    public function activitiesFilter($reportList)
    {
      $activities = $this->activitiesTracker->getActivitiesData($reportList);

      return [
          'unvalidated'   => $activities[0],
          'validated'     => $activities[1],
          'starsGathered' => $activities[2]
      ];
    }
}

