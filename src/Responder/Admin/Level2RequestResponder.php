<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 14:04
 */

namespace App\Responder\Admin;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class Level2RequestResponder
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * Level2RequestResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param array $userList
     * @param string $title
     * @return Response
     */
    public function __invoke(array $userList, string $title)
    {
        return new Response(
            $this->twig->render('admin\adminMembers.html.twig',[
                'userList' => $userList,
                'title'    => $title
            ])
        );
    }
}