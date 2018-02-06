<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 23/09/17
 * Time: 22:45
 */

namespace App\Controller;

use App\Form\Login;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class IndexController extends Controller
{




    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function accountLvl2Request()
    {
       $view = $this->get('App\Builders\AdminBuilder')
           ->buildAccountLvl2Request()
       ;

       return $this->render('admin\adminMembers.html.twig',[
           'userList' => $view[0],
           'title'    => $view[1]
       ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function unactivatedAccount()
    {
        $view  = $this->get('App\Builders\AdminBuilder')
            ->buildUnactivatedList();

        return $this->render('admin\unactivatedAccount.html.twig',[
            'userList' => $view[0],
            'title'    => $view[1]
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function statistics(Request $request)
    {
        $view = $this->get('App\Builders\AdminBuilder')
            ->buildStatistics($request)
        ;

        return $this->render('admin\adminStats.html.twig',[
            'totalReport'     => $view[0],
            'monthlyTotal'    => $view[1],
            'yearlyTotal'     => $view[2],
            'dailyAverage'    => $view[3],
            'monthlyAverage'  => $view[4],
            'averageByUser'   => $view[5],
            'totalByLevel1'   => $view[6],
            'totalByLevel2'   => $view[7],
            'averageByLevel1' => $view[8],
            'averageByLevel2' => $view[9]
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function accountManagement(Request $request)
    {
        $this->get('App\Builders\AdminBuilder')
            ->buildAccountManagement($request)
        ;
        $redirect = $request->headers->get('referer');
        return $this->redirect($redirect);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listReportedBird()
    {
       $view = $this->get('App\Builders\AdminBuilder')
            ->buildReportedBird()
        ;

        return $this->render('admin\adminBird.html.twig',[
            'reportedBird' => $view,
        ]);
    }
}

