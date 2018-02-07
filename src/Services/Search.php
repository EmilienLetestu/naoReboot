<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 16/11/2017
 * Time: 10:39
 */

namespace App\Services;

use App\Entity\Bird;
use App\Form\NavSearchType;
use App\Managers\ReportManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class Search
{
    /**
     * @var FormFactory
     */
    private $formFactory;

    /**
     * @var EntityManager
     */
    private $doctrine;


    /**
     * Search constructor.
     * @param FormFactory $formFactory
     * @param EntityManager $doctrine
     */
    public function __construct(
        FormFactory   $formFactory,
        EntityManager $doctrine
    )
    {
        $this->formFactory  = $formFactory;
        $this->doctrine     = $doctrine;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function processSearch(Request $request)
    {
        $searchForm = $this->formFactory->create(NavSearchType::class);
        $searchForm->handleRequest($request);

        if($searchForm->isSubmitted() && $searchForm->isValid())
        {

          $repository = $this->doctrine->getRepository(Bird::class);

           return[
               $repository->findBirdLike($searchForm->get('search')->getData()),
               $searchForm->get('search')->getData()
           ];
        }

    }

    /**
     * @return \Symfony\Component\Form\FormView
     */
    public function createSearch()
    {
        $searchForm = $this->formFactory->create(NavSearchType::class);

        return $searchForm->createView();
    }


}

