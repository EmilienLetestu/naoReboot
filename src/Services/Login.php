<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 02/10/17
 * Time: 19:16
 */

namespace App\Services;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class Login
{
    private $security;

    /**
     * Login constructor.
     * @param AuthorizationChecker $security
     */
    public function  __construct(AuthorizationChecker $security)
    {
        $this->security  = $security;
    }

    /**
     * @param Request $request
     * @param AuthenticationUtils $authUtils
     * @return array|string
     */
    public function processLogin(Request $request,AuthenticationUtils $authUtils)
    {
        if ( $this->security->isGranted('IS_AUTHENTICATED_REMEMBERED')) {

            return $redirect = 'home';
        }

        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return [
            $lastUsername,
            $error]
        ;

    }
}