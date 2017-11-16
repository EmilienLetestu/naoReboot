<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 16/11/2017
 * Time: 10:39
 */

namespace App\Services;



use App\Entity\Report;
use App\Form\FilterType;
use App\Form\SearchType;
use App\Managers\ReportManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

class Search
{
    private $formFactory;
    private $doctrine;
    private $reportManager;

    public function __construct(
        FormFactory   $formFactory,
        EntityManager $doctrine,
        ReportManager $reportManager
    )
    {
        $this->formFactory = $formFactory;
        $this->doctrine    = $doctrine;
        $this->reportManager = $reportManager;
    }

    public function processSearch(Request $request)
    {
        $searchForm = $this->formFactory->create(SearchType::class);

        $searchForm->handleRequest($request);

        if($searchForm->isSubmitted() && $searchForm->isValid())
        {
            $birdId = $searchForm->get('bird')->getData();

            $repository = $this->doctrine->getRepository(Report::class);

            $report = $repository->findAllWithBirdName($birdId);

            return $report;
        }

        return $searchForm->createView();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function processFilter(Request $request)
    {
        $filterForm = $this->formFactory->create(FilterType::class);

        $filterForm->handleRequest($request);

        if($filterForm->isSubmitted() && $filterForm->isValid())
        {
            $route  = $filterForm->get('route')->getData();
            $ordering  = $filterForm->get('order')->getData();
            $bird   = $filterForm->get('bird')->getData();

            $validated = $route !==4 ? $route = 1 : $route = 0;
            $ordering === 3 ? $order = 'bird' : $order = 'addedOn';
            $order === 'addedOn' && $ordering === 1 ? $sort = 'DESC' : $sort = 'ASC';

            if($bird === null)
            {
                $repository = $this->doctrine->getRepository(Report::class);

                return [
                    $filterForm->createView(),
                    $repository->findSelection($validated , $sort, $order)
                ];
            }

            $repository = $this->doctrine->getRepository(Report::class);

            return [
                $filterForm->createView(),
                $repository->findAllWithBirdName($bird->getId())
            ];
        }

        return [
            $filterForm->createView(),
            $this->reportManager->displayAllValidated()
        ];
    }


}
