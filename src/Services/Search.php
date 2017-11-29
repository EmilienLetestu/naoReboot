<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 16/11/2017
 * Time: 10:39
 */

namespace App\Services;

use App\Form\NavSearchType;
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
        $searchForm = $this->formFactory->create(NavSearchType::class);
        $searchForm->handleRequest($request);

        if($searchForm->isSubmitted() && $searchForm->isValid())
        {

        }

        return $searchForm->createView();
    }


}

