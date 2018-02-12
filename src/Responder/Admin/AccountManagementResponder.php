<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 16:46
 */

namespace App\Responder\Admin;


use Symfony\Component\HttpFoundation\RedirectResponse;

class AccountManagementResponder
{
    /**
     * @param $referer
     * @return RedirectResponse
     */
    public function __invoke($referer)
    {
        return new RedirectResponse($referer);
    }
}
