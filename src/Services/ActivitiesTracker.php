<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 14/11/2017
 * Time: 11:37
 */

namespace App\Services;

use App\Entity\Report;
use Doctrine\ORM\EntityManager;

class ActivitiesTracker
{
    private $doctrine;

    /**
     * ProfileBuilder constructor.
     * @param EntityManager $doctrine
     */
    public function __construct(EntityManager $doctrine
    )
    {
        $this->doctrine   = $doctrine;
    }

    /**
     * fetch last publication and extract needed data
     * @param $id
     * @return array
     */
    public function getLastPublicationData($id)
    {
        //fetch last published one
        $lastReport = $this->doctrine->getRepository(Report::class)
            ->findUserLastPublication($id);

        if(!$lastReport)
        {
            return [
                $date   = '-------------',
                $bird   = '-------------',
                $satNav = '-------------'];
        }

        foreach ($lastReport as $report)
        {
            $date   = $report->getAddedOn()->format('d-m-y');
            $bird   = $report->getBird()->getSpeciesFr();
            $satNav = $report->getSatNav();
        }

        return  [
            $date,
            $bird,
            $satNav]
            ;
    }

    /**
     * extract general information from user publications
     * @param $reportList
     * @return array
     */
    public function getActivitiesData($reportList)
    {
        if(count($reportList) === 0)
        {
            return [
                0,
                0,
                0,
            ];
        }
        foreach ($reportList as $report)
        {
            $stars[] = $report->getStarNbr();
            $validations[] = $report->getValidated();
            $unvalidated[] = array_search(0,$validations);
            $validated[] = array_search(1,$validations);
        }

        return [
            count($unvalidated),
            count($validated),
            array_sum($stars)
        ];
    }
}
