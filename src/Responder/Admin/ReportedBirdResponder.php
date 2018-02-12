<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 17:29
 */

namespace App\Responder\Admin;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ReportedBirdResponder
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * ReportedBirdResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function __invoke(array $birdList)
    {
        return new Response(
            $this->twig->render('admin\adminBird.html.twig',[
                'reportedBird' => $birdList
            ])
        );
    }

}

