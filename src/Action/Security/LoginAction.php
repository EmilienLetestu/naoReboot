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
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginAction
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authCheck;

    /**
     * @var
     */
    private $urlGenerator;

    /**
     * LoginAction constructor.
     * @param AuthorizationCheckerInterface $authCheck
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        AuthorizationCheckerInterface $authCheck,
        UrlGeneratorInterface         $urlGenerator
    )
    {
        $this->authCheck    = $authCheck;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param AuthenticationUtils $authenticationUtils
     * @param LoginResponder $responder
     * @return string|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(AuthenticationUtils $authenticationUtils, LoginResponder $responder)
    {
        if($this->authCheck->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            return new RedirectResponse(
                $this->urlGenerator->generate('home')
            );
        }

        return $responder(
            $authenticationUtils->getLastUsername(),
            $authenticationUtils->getLastAuthenticationError()
        );


    }
}

