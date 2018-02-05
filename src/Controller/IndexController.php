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
    public function landing(Request $request)
    {
        $view = $this->get('App\Services\Register')
            ->registerUser($request)
        ;

        if($view === 'home')
        {
            return $this->redirectToRoute($view);
        }

        return $this->render('nao\landingPage.html.twig',[
            'form' => $view
        ]);
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function browseReport(Request $request)
    {
        $view =  $this->get('App\Services\BrowserFilter')
            ->processFilter($request)
        ;

        return $this->render('nao\browseReport.html.twig',[
            'filter'   => $view[0],
            'reports'  => $view[1],
            'title'    => $view[2],
            'birdId'   => $view[3]
        ]);
    }

    public function search(Request $request)
    {
        $view =  $this->get('App\Services\Search')
          ->processSearch($request)
        ;

        return $this->render('nao\searchResult.html.twig',[
            'results'    => $view[0],
            'userSearch' => $view[1]
        ]);
    }

    public function birdHistory(Request $request)
    {
        $view = $this->get('App\Builders\HistoryBuilder')
            ->buildHistory($request)
        ;

        return $this->render('nao\birdHistory.html.twig',[
            'reports' => $view[0],
            'birdId'  => $view[1],
            'species' => $view[2]
        ]);
    }

    /**
     * @param AuthenticationUtils $authUtils
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/connexion", name="login")
     */
    public function login(AuthenticationUtils $authUtils)
    {
        $view = $this->get('App\Services\Login')->processLogin($authUtils);

        return $this->render(
            'nao\connectionForms.html.twig',
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
            'nao\connectionForms.html.twig',
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
            'nao\connectionForms.html.twig',
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
            'nao\connectionForms.html.twig',
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
            'nao\addReportForm.html.twig',
            ['form' => $view]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profile(Request $request)
    {
        $view = $this->get('App\Builders\ProfileBuilder')
            ->getProfileVersion($request)
        ;

        return $this->render('nao\profile.html.twig',[
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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function validateReport(Request $request)
    {
        $this->get('App\Managers\ValidationManager')
            ->validationProcess($request->get('reportId'))
        ;
        $redirect = $request->headers->get('referer');
        return $this->redirect($redirect);

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userNotification()
    {
        $view = $this->get('App\Managers\NotificationManager')
            ->getNotificationToDisplay()
        ;

        return $this->render('nao\notification.html.twig',[
           'notificationList' => $view
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function terms()
    {
        return $this->render('nao\terms.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function aboutUs(Request $request)
    {
        $view = $this->get('App\Services\Contact')
            ->processContact($request)
        ;

        return $this->render('nao\aboutUs.html.twig',[
            'form' => $view
        ]);
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function administration(Request $request)
    {
       $view = $this->get('App\Builders\AdminBuilder')
           ->buildAdminHome($request)
       ;

       if($view[3] === 'admin')
       {
           return $this->redirectToRoute('admin');
       }

        return $this->render('admin\admin.html.twig',[
            'minLevel' => $view[0],
            'maxLevel' => $view[1],
            'homeImg'  => $view[2],
            'form'     => $view[3],
            'title'    => $view[4]
        ]);
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userList()
    {
        $view = $this->get('App\Builders\AdminBuilder')
            ->builduserList()
        ;

        return $this->render('admin\adminMembers.html.twig',[
            'userList'   => $view[0],
            'lastReport' => $view[1],
            'title'      => $view[2]
        ]);
    }

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

    /**
     * @return mixed
     */
    public function export(){

        return $this->get('App\Services\ExportCsv')
            ->encodeTable()
        ;
    }
}

