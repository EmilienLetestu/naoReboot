<?php

/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 09:59
 */

namespace App\Responder;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class HomeResponder
{
    private $twig;

    /**
     * HomeResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function __invoke($reports, $homeImg)
    {
        return new Response(
            $this->twig->render('nao\home.html.twig',[
                'reports' => $reports,
                'homeImg'=>$homeImg
            ])
        );
    }
}