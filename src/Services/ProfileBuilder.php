<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 03/10/17
 * Time: 23:01
 */

namespace App\Services;

use App\Entity\Report;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class ProfileBuilder
{
    private $doctrine;
    private $session;
    private $token;
    private $tools;
    private $updatePswd;

    /**
     * ProfileBuilder constructor.
     * @param EntityManager $doctrine
     * @param Session $session
     * @param TokenStorage $token
     * @param Tools $tools
     * @param UpdatePswd $updatePswd
     */
    public function __construct(
        EntityManager $doctrine,
        Session       $session,
        TokenStorage  $token,
        Tools         $tools,
        UpdatePswd    $updatePswd
    )
    {
        $this->doctrine   = $doctrine;
        $this->session    = $session;
        $this->token      = $token;
        $this->tools      = $tools;
        $this->updatePswd = $updatePswd;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function buildOwnerProfile(Request $request)
    {
        //fetch id and createdOn into tokenStorage
        $user      = $this->token->getToken()->getUser();
        $id        = $user->getId();
        $createdOn = $user->getCreatedOn()->format('d-m-Y');
        $role = $user->getRoles();

        //get account type
        $accountType = $this->tools->displayAccountType($role);

        //change pswd process
        $changePswd = $this->updatePswd->changePswd($request);

        //fetch last published one
        $repository = $this->doctrine->getRepository(Report::class);
        $lastReport = $repository->findUserLastPublication($id);
        foreach ($lastReport as $report)
        {
            $date   = $report->getAddedOn()->format('d-m-y');
            $bird   = $report->getBird()->getSpeciesFr();
            $satNav = $report->getSatNav();
        }

        //fetch all user reports
        $reportList = $repository->findByUser($id);
        foreach ($reportList as $report)
        {
            //get all stars gathered
            $stars[] = $report->getStarNbr();
            //get all validated and unvalidated
            $validations[] = $report->getValidated();
            $unvalidated[]  = array_search(false,$validations);
            $validated[]    = array_search(1,$validations);
        }

        $accountInfo = [$createdOn, $changePswd ,$accountType,array_sum($stars)];
        $lastInfo= [$date, $bird, $satNav];
        $reportsInfo=[count($unvalidated),count($validated)];

        return [
            $accountInfo,
            $lastInfo,
            $reportsInfo,
            $reportList
        ];
    }
}