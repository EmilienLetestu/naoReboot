<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 10:32
 */

namespace App\Responder;

use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class LandingResponder
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * LandingResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param $form
     * @return Response
     */
    public function __invoke(FormView $form)
    {
        return new Response(
            $this->twig->render('nao\landingPage.html.twig',[
                'form' => $form
            ])
        );
    }
}
