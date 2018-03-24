<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 24/03/2018
 * Time: 12:27
 */

namespace App\Responder;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ActivationMailResponder
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * NewValidationMailResponder constructor.
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @return RedirectResponse
     */
    public function __invoke()
    {
        return new RedirectResponse(
            $this->urlGenerator->generate('home')
        );
    }
}
