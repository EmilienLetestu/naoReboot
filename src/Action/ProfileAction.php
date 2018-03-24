<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 17:08
 */

namespace App\Action;


use App\Responder\ProfileResponder;
use App\Services\ActivitiesTracker;
use App\Services\ProfileBuilder;
use App\Services\UpdatePswd;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProfileAction
{
    private $token;
    private $updatePswd;
    private $activitiesTracker;
    private $profileBuilder;
    private $urlGenerator;
    private $session;

    /**
     * ProfileAction constructor.
     * @param TokenStorageInterface $token
     * @param UpdatePswd $updatePswd
     * @param ActivitiesTracker $activitiesTracker
     * @param ProfileBuilder $profileBuilder
     * @param UrlGeneratorInterface $urlGenerator
     * @param SessionInterface $session
     */
    public function __construct(
        TokenStorageInterface      $token,
        UpdatePswd                 $updatePswd,
        ActivitiesTracker          $activitiesTracker,
        ProfileBuilder             $profileBuilder,
        UrlGeneratorInterface      $urlGenerator,
        SessionInterface           $session

    )
    {
        $this->token             = $token;
        $this->updatePswd        = $updatePswd;
        $this->activitiesTracker = $activitiesTracker;
        $this->profileBuilder    = $profileBuilder;
        $this->urlGenerator      = $urlGenerator;
        $this->session           = $session;
    }

    public function __invoke(Request $request, ProfileResponder $responder)
    {
       $id = $request->attributes->get('id');
       $user = $this->token->getToken()->getUser();
       $userId = $user->getId();


       $profile = $this->profileBuilder->getProfileVersion(
           $request,
           $id,
           $userId,
           $user,
           $this->activitiesTracker,
           $this->updatePswd
       );

        if(!$profile){
            $this->session->getFlashBag()
                ->add('denied','Ce compte n\'existe plus');
            return new RedirectResponse(
                $this->urlGenerator->generate('home')
            );
        }

       return $responder(
           $profile[0],
           $profile[1],
           $profile[2],
           $profile[3]
       );
    }
}
