<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 14:17
 */

namespace App\Responder\Admin;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class UnactivatedListResponder
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * UnactivatedListResponder constructor.
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
            $this->twig->render('admin\unactivatedAccount.html.twig',[
                'userList' => $userList,
                'title'    => $title
            ])
        );
    }

}