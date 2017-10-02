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
use Symfony\Component\HttpFoundation\Session\Session;

class IndexController extends Controller
{
    public function home()
    {

        return $this->render('home.html.twig');
    }

    public function login()
    {
        $view = $this->get('form.factory')->create(Login::class);
        return $this->render(
            'connectionForms.html.twig',
            ['form' => $view->createView()]
        );
    }

    public function register(Request $request)
    {
        $view = $this->get('App\Services\Register')->registerUser($request);
        if($view === 'home')
        {
            return $this->redirectToRoute($view);
        }
        return $this->render(
            'connectionForms.html.twig',
            ['form' => $view[0]]
        );
    }

    public function activate(Request $request)
    {
        $this->get('App\Services\ActivateAccount')->ActivateUserAccount($request);

        return $this->redirectToRoute('home');
    }

    public function resetPswdMail(Request $request)
    {
        $view = $this->get('App\Services\ResetPswd')->askReset($request);

        return $this->render(
            'connectionForms.html.twig',
            ['form'=>$view]
        );
    }

    public function resetPswdForm(Request $request)
    {
        $view = $this->get('App\Services\ResetPswd')->resetPswd($request);

        if($view === 'home')
        {
            return $this->redirectToRoute($view);
        }
        return $this->render(
            'connectionForms.html.twig',
            ['form'=> $view]
        );
    }

    public function addReport(Request $request)
    {
        $view = $this->get('App\Services\AddReport')->addReportProcess($request);

        return $this->render(
            'addReportForm.html.twig',
            ['form' => $view]
        );
    }

}