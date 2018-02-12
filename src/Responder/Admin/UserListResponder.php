<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 11:08
 */

namespace App\Responder\Admin;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class UserListResponder
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * UserListResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param array $userList
     * @param array $lastReport
     * @param string $title
     * @return Response
     */
    public function __invoke(array $userList, array $lastReport, string $title)
    {
       return new Response(
           $this->twig->render('admin\adminMembers.html.twig',[
               'userList'   => $userList,
               'lastReport' => $lastReport,
               'title'      => $title
           ])
       );
    }
}
