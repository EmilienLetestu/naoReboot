<?php
namespace App\Responder\Security;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 14:31
 */
class LoginResponder
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * LoginResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param $lastUsername
     * @param $error
     * @return Response
     */
    public function __invoke($lastUsername, $error)
    {
        return new Response(
            $this->twig->render('nao\connectionForms.html.twig',[
                'last_username' => $lastUsername,
                'error'         => $error
            ])
        );
    }
}
