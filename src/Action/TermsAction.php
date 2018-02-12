<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 09:39
 */

namespace App\Action;


use App\Responder\TermsResponder;

class TermsAction
{
    public function __invoke(TermsResponder $responder)
    {
        return $responder();
    }
}

