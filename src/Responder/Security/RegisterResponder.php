<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 14:55
 */

namespace App\Responder\Security;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormView;
use Twig\Environment;

class RegisterResponder
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * RegisterResponder constructor.
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
          $this->twig->render('nao\connectionForms.html.twig',[
              'form' => $form
          ])
      );
    }
}