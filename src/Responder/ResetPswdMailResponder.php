<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 15:54
 */

namespace App\Responder;


use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ResetPswdMailResponder
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * ResetPswdResponder constructor.
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
