<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 15:19
 */

namespace App\Responder;


use Symfony\Component\HttpFoundation\RedirectResponse;

class ActivateResponder
{
    /**
     * @return RedirectResponse
     */
    public function __invoke()
    {
        return new RedirectResponse('/accueil');
    }
}