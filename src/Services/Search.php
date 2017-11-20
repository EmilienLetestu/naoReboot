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
use App\Form\UserFilterType;
use App\Managers\ReportManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class Search
{
    private $formFactory;
    private $doctrine;
    private $reportManager;
    private $token;
    private $authCheck;

    public function __construct(
        FormFactory          $formFactory,
        EntityManager        $doctrine,
        ReportManager        $reportManager,
        TokenStorage         $token,
        AuthorizationChecker $authCheck
    )
    {
        $this->formFactory       = $formFactory;
        $this->doctrine          = $doctrine;
        $this->reportManager     = $reportManager;
        $this->token             = $token;
        $this->authCheck         = $authCheck;
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
     * Decide which form builder to call based on user role
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getFormToGenerate()
    {
        return $this->authCheck->isGranted('ROLE_VALIDATOR')?
            $this->formFactory->create(FilterType::class):
            $this->formFactory->create(UserFilterType::class)
            ;
    }

    /**
     * create filter form
     * @param Request $request
     * @return array
     */
    public function createFilter(Request $request)
    {
        $filterForm = $this->getFormToGenerate();
        $route = $request->attributes->get('_route');

        return [
            $filterForm->createView(),
            $this->getReportToDisplay($request),
            $this->getTitle($route,null)
        ];
    }

    /**
     * select report list based on url
     * @param Request $request
     * @return array|mixed
     */
    public function getReportToDisplay(Request $request)
    {
        $route = $request->attributes->get('_route');

        return $route === 'report' ?
            $this->reportManager->displayAllValidated() :
            $this->reportManager->displayAllUnvalidated()
        ;
    }

    /**
     * @param $route
     * @param $validated
     * @return string
     */
    public function getTitle($route,$validated)
    {
        return $route === 'report' || $validated === 1 ?
            'Observations validées' : 'Observations en attentes de validation'
        ;
    }

    /**
     * @param $bird
     * @param $validated
     * @return string
     */
    public function getBirdTitle($validated ,$bird)
    {
        return $validated === 1 ?
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

        $filterForm = $this->getFormToGenerate();
        $filterForm->handleRequest($request);

        $user = $this->token->getToken()->getUser();

        if($filterForm->isSubmitted() && $filterForm->isValid())
        {
            $user->getOnHold() === true ? $route = 1 : $route = $filterForm->get('route')->getData();
            $ordering  = $filterForm->get('order')->getData();
            $bird   = $filterForm->get('bird')->getData();

            //prepare query
            $validated = $route === 1 ? $route = 1 : $route = 0;
            $ordering === 3 ? $order = 'bird' : $order = 'addedOn';
            $order === 'addedOn' && $ordering === 1 ? $sort = 'DESC' : $sort = 'ASC';

            $repository = $this->doctrine->getRepository(Report::class);

            if($bird === null)
            {

                return [
                    $filterForm->createView(),
                    $repository->findSelection($validated , $sort, $order),
                    $this->getTitle($route,$validated),
                    null
                ];
            }

            return [
                $filterForm->createView(),
                $repository->findSelectionWithBird($validated,$sort,$order,null,$bird->getBird()->getId()),
                $this->getBirdTitle($validated, $bird->getBird()->getSpeciesFr()),
                $bird->getBird()->getId()
            ];
        }
    }

}

