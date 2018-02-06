<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 09:39
 */

namespace App\Responder;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class TermsResponder
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * TermsResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @return Response
     */
    public function __invoke()
    {
        return new Response(
            $this->twig->render('nao\terms.html.twig')
        );
    }
}
