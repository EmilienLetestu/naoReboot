<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 05/10/17
 * Time: 12:50
 */

namespace App\Services;

use App\Entity\Report;
use App\Entity\User;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class AdminBuilder
{
    private $doctrine;
    private $homeImg;


    public function __construct(
        EntityManager $doctrine,
        HomeImg       $homeImg
    )
    {
        $this->doctrine = $doctrine;
        $this->homeImg  = $homeImg;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function buildAdminHome(Request $request)
    {
        //get user list
        $repository = $this->doctrine->getRepository(User::class);

        //homepage img modification
        Return [
            count($repository->countAllWithAccessLevel(1)),
            count($repository->countAllWithAccessLevel(2)),
            $this->homeImg->getHomeImage(),
            $this->homeImg->addPictureToHomePage($request)
        ];
    }

    public function buildUserList()
    {
        //get all activated account
        $repository = $this->doctrine->getRepository(User::class);
        $repo = $this->doctrine->getRepository(Report::class);

        $userList = $repository->findAllActivated();

        foreach ($userList as $user)
        {
            $idList[] = $user->getId();
        }
        foreach ($idList as $id)
        {
            $report[] = $repo->findUserLastPublication($id);
        }

        Return [
            $repository->findAllActivated(),
            $report
        ];
    }

    public function buildStatistics()
    {
        // total of validated report
        $repoReport = $this->doctrine->getRepository(Report::class);
        $repoUser   = $this->doctrine->getRepository(User::class);

        //total
        $totalReport     = count($repoReport->countAllValidated());
        $totalUser       = count($repoUser->countAllActivated());


        // reference value for date based stats
        $yearlyTotal    = count($repoReport->countValidatedThisYear(date('Y')));

        // reference values for user based stats
        $allReportByUserLevel2 = count($repoReport->countWithUserAccessLevel(1));
        $allReportByUserLevel1 = $totalReport - $allReportByUserLevel2;

        // prevent to divide by 0
        $average1 = $allReportByUserLevel1 > 0 ? $totalReport / $allReportByUserLevel1 : 0;
        $average2 = $allReportByUserLevel2 > 0 ? $totalReport / $allReportByUserLevel2 : 0;

        return [
            $totalReport,
            count($repoReport->countValidatedThisMonth(date('Y'),date('m'))),
            $yearlyTotal,
            $yearlyTotal / 365.4,
            $yearlyTotal / 12,
            $totalReport / $totalUser,
            $allReportByUserLevel1,
            $allReportByUserLevel2,
            $average1,
            $average2,
        ];
    }

}

