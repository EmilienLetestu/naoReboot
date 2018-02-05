<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 11:44
 */

namespace App\Responder;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class SearchResponder
{
    private $twig;

    /**
     * SearchResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function __invoke(array $results, $userSearch)
    {
        return new Response(
            $this->twig->render('nao\searchResult.html.twig',[
                'results'    => $results,
                'userSearch' => $userSearch
            ])
        );
    }
}