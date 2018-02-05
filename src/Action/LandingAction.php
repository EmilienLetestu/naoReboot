<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 10:24
 */

namespace App\Action;


use App\Responder\LandingResponder;
use App\Services\Register;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LandingAction
{
    private $register;
    private $urlGenerator;

    public function __construct(
        Register $register,
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->register     = $register;
        $this->urlGenerator = $urlGenerator;
    }

    public function __invoke(Request $request, LandingResponder $responder)
    {
        $form = $this->register->registerUser($request);

        if($form === 'home')
        {
            return new RedirectResponse(
                $this->urlGenerator
                     ->generate('home')
            );
        }

        return $responder ($form);
    }
}