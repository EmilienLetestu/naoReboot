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


    public function __construct(FormFactory  $formFactory)
    {
        $this->formFactory       = $formFactory;
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

