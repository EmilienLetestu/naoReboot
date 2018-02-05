<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 14:36
 */
namespace App\Action\Security;


use App\Responder\Security\LoginResponder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginAction
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authCheck;

    /**
     * LoginAction constructor.
     * @param AuthorizationCheckerInterface $authCheck
     */
    public function __construct(AuthorizationCheckerInterface $authCheck)
    {
        $this->authCheck = $authCheck;
    }

    /**
     * @param AuthenticationUtils $authenticationUtils
     * @param LoginResponder $responder
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(AuthenticationUtils $authenticationUtils, LoginResponder $responder)
    {
        if($this->authCheck->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            return new RedirectResponse('/accueil');
        }

        return $responder(
            $authenticationUtils->getLastUsername(),
            $authenticationUtils->getLastAuthenticationError()
        );


    }
}