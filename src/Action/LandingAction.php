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
    /**
     * @var Register
     */
    private $register;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * LandingAction constructor.
     * @param Register $register
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        Register $register,
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->register     = $register;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param Request $request
     * @param LandingResponder $responder
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
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
