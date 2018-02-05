<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 11:58
 */

namespace App\Responder;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class BirdHistoryResponder
{
    private $twig;

    /**
     * BirdHistoryResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function __invoke(string $birdId, array $reports, string $species)
    {
        return new Response(
            $this->twig->render('nao\birdHistory.html.twig',[
                'birdId'  => $birdId,
                'reports' => $reports,
                'species' => $species
            ])
        );
    }
}