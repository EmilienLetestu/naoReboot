<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 15/11/2017
 * Time: 13:22
 */

namespace App\Twig;

use App\Services\ActivitiesTracker;

class LastPublicationTypeExtension extends \Twig_Extension
{
    private  $activitiesTracker;


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
            new \Twig_SimpleFilter('lastPublication',[$this,'lastPublicationFilter'])
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function lastPublicationFilter($id)
    {
        $lastPublication = $this->activitiesTracker->getLastPublicationData($id);

        return [
            'date'   => $lastPublication[0],
            'bird'   => $lastPublication[1],
            'satNav' => $lastPublication[2]
        ];
    }
}
