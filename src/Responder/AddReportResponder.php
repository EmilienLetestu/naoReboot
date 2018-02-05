<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 16:41
 */

namespace App\Responder;


use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class AddReportResponder
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * AddReportResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param FormView $form
     * @return Response
     */
    public function __invoke(FormView $form)
    {
       return new Response(
           $this->twig->render('nao\addReportForm.html.twig',[
               'form' => $form
           ])
       );
    }
}
