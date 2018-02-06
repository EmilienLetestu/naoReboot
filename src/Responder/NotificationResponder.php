<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 08:45
 */

namespace App\Responder;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class NotificationResponder
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * NotificationResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param array $notificationList
     * @return Response
     */
    public function __invoke(array $notificationList)
    {
       return new Response(
           $this->twig->render('nao\notification.html.twig',[
               'notificationList' => $notificationList
           ])
       );
    }
}