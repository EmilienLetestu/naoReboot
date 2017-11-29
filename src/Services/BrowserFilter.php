<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 29/11/2017
 * Time: 11:56
 */

namespace App\Services;

use App\Entity\Report;
use App\Form\FilterType;
use App\Form\UserFilterType;
use App\Managers\ReportManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;


class BrowserFilter
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
        $state = $request->attributes->get('state');

        return [
            $filterForm->createView(),
            $this->getReportToDisplay($request),
            $this->getTitle($state)
        ];
    }

    /**
     * select report list based on url
     * @param Request $request
     * @return array|mixed
     */
    public function getReportToDisplay(Request $request)
    {
        $state = $request->attributes->get('state');

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
                $bird->getBird()->getId(),
            ];
        }
    }
}