<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 29/11/2017
 * Time: 11:56
 */

namespace App\Services;

use App\Entity\Report;
use App\Form\Type\FilterType;
use App\Form\Type\UnvalidatedFilterType;
use App\Managers\ReportManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;


class BrowserFilter
{
    private $formFactory;
    private $doctrine;
    private $reportManager;

    public function __construct(
        FormFactory          $formFactory,
        EntityManager        $doctrine,
        ReportManager        $reportManager
    )
    {
        $this->formFactory       = $formFactory;
        $this->doctrine          = $doctrine;
        $this->reportManager     = $reportManager;
    }

    /**
     * Decide which form builder to call based on route param
     * @param $state
     * @return \Symfony\Component\Form\FormInterface
     */
    public function generateForm($state)
    {
        return $state === 'valide' ?
            $this->formFactory->create(FilterType::class):
            $this->formFactory->create(UnvalidatedFilterType::class)
        ;
    }

    /**
     * create filter form
     * @param Request $request
     * @return array
     */
    public function createFilter(Request $request)
    {
        $state = $request->attributes->get('state');
        $filterForm = $this->generateForm($state);

        return [
            $filterForm->createView(),
            $this->getReportToDisplay($request),
            $this->getTitle($state)
        ];
    }

    /**
     * @param $state
     * @return mixed
     */
    public function getReportToDisplay($state)
    {

        return $state === 'valide' ?
            $this->reportManager->displayAllValidated() :
            $this->reportManager->displayAllUnvalidated()
        ;
    }

    /**
     * @param $state
     * @return string
     */
    public function getTitle($state)
    {
        return $state === 'valide' ?
            'Observations validées' : 'Observations en attentes de validation'
            ;
    }

    /**
     * @param $state
     * @param $bird
     * @return string
     */
    public function getBirdTitle($state ,$bird)
    {
        return $state === 'valide' ?
            'Historique des observations: '.$bird :
            'Observations en attentes de validation: '.$bird
       ;
    }

    /**
     * create filter form and process it
     * @param Request $request
     * @return array
     */
    public function processFilter(Request $request)
    {
        $state = $request->attributes->get('state');

        $filterForm = $this->generateForm($state);
        $filterForm->handleRequest($request);

        
        if($filterForm->isSubmitted() && $filterForm->isValid())
        {
            $ordering  = $filterForm->get('order')->getData();
            $bird   = $filterForm->get('bird')->getData();

            //prepare query
            $state === 'valide' ? $validated = 1 : $validated = 0;
            $ordering === 3 ? $order = 'bird' : $order = 'addedOn';
            $order === 'addedOn' && $ordering === 1 ? $sort = 'DESC' : $sort = 'ASC';

            $repository = $this->doctrine->getRepository(Report::class);

            if($bird === null)
            {
                return [
                    $filterForm->createView(),
                    $repository->findSelection($validated , $sort, $order),
                    $this->getTitle($state),
                    null

                ];
            }
            return [
                $filterForm->createView(),
                $repository->findSelectionWithBird($validated,$sort,$order,null,$bird->getBird()->getId()),
                $this->getBirdTitle($state, $bird->getBird()->getSpeciesFr()),
                $bird->getBird()->getId(),
            ];
        }

        return [
            $filterForm->createView(),
            $this->getReportToDisplay($state),
            $this->getTitle($state),
            null
        ];
    }
}
