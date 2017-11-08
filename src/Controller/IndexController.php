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
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class IndexController extends Controller
{


    public function home(Request $request)
    {

        $view = $this->get('App\Managers\ReportManager')->displayHomePageReport();
        return $this->render('home.html.twig',['reports'=>$view]);
    }

    /**
     * @param AuthenticationUtils $authUtils
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/connexion", name="login")
     */
    public function login(AuthenticationUtils $authUtils)
    {
        $view = $this->get('App\Services\Login')->processLogin($authUtils);

        if($view === 'home')
        {
            return $this->redirectToRoute($view);
        }

        return $this->render(
            'connectionForms.html.twig',
            [
                'last_username' =>$view[0],
                'error' => $view[1]]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request)
    {
        $view = $this->get('App\Services\Register')
            ->registerUser($request);
        if($view === 'home')
        {
            return $this->redirectToRoute($view);
        }

        return $this->render(
            'connectionForms.html.twig',
            ['form' => $view]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function activate(Request $request)
    {
        $this->get('App\Services\ActivateAccount')
            ->ActivateUserAccount($request);

        return $this->redirectToRoute('home');
    }

    public function resetPswdMail(Request $request)
    {
        $view = $this->get('App\Services\UpdatePswd')
            ->askReset($request);

        return $this->render(
            'connectionForms.html.twig',
            ['form'=>$view]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function resetPswdForm(Request $request)
    {
        $view = $this->get('App\Services\UpdatePswd')
            ->resetPswd($request);

        if($view === 'home')
        {
            return $this->redirectToRoute($view);
        }

        return $this->render(
            'connectionForms.html.twig',
            ['form'=> $view]
        );
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addReport(Request $request)
    {
        $view = $this->get('App\Services\AddReport')
            ->addReportProcess($request)
        ;

        return $this->render(
            'addReportForm.html.twig',
            ['form' => $view]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profile(Request $request)
    {
        $view = $this->get('App\Services\ProfileBuilder')
            ->buildPrivateProfile($request)
        ;

        return $this->render('profile.html.twig',[
            'accountInfo' => $view[0],
            'lastInfo'    => $view[1],
            'reportList'  => $view[2],
            'reportInfo'  => $view[3]
        ]);

    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function starReport(Request $request)
    {

       $this->get('App\Managers\StarManager')
           ->starProcess($request->get('reportId'))
       ;
       $redirect = $request->headers->get('referer');
       return $this->redirect($redirect);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function administration(Request $request)
    {
       $view = $this->get('App\Services\AdminBuilder')
           ->buildAdminHome($request)
       ;

       if($view[3] === 'admin')
       {
           return $this->redirectToRoute('admin');
       }

        return $this->render('admin.html.twig',[
            'minLevel' => $view[0],
            'maxLevel' => $view[1],
            'homeImg'  => $view[2],
            'form'     => $view[3]
        ]);
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userList()
    {
        $view = $this->get('App\Services\AdminBuilder')
            ->builduserList()
        ;

        return $this->render('adminMembers.html.twig',[
            'userList'   => $view[0],
            'lastReport' => $view[1]
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function statistics()
    {
        $view = $this->get('App\Services\AdminBuilder')
            ->buildStatistics()
        ;

        return $this->render('adminStats.html.twig',[
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
        $this->get('App\Services\AdminBuilder')
            ->buildAccountManagement($request)
        ;

        return $this->redirectToRoute('userList');
    }

}

