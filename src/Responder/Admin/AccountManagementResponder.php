<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 16:46
 */

namespace App\Responder\Admin;


use Symfony\Component\HttpFoundation\Response;

class AccountManagementResponder
{
    /**
     * @param $result
     * @return Response
     */
    public function __invoke($result)
    {
        $response = new Response($result);
        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }
}
