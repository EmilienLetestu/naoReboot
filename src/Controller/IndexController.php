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

