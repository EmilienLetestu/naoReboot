<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 19/02/2018
 * Time: 17:27
 */

namespace App\EventListener;


use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class SecurityListener
{
    /**
     * @var SessionInterface
     */
    private $session;


    /**
     * AuthenticationListener constructor.
     * @param SessionInterface $session
     */
    public  function __construct(
        SessionInterface $session
    )
    {
        $this->session = $session;
    }

    /**
     * @param InteractiveLoginEvent $event
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();

        $this->session->getFlashBag()
            ->add('success',
                'Boujour ' .$user->getName().' '.$user->getSurname().' content de vous revoir !'
            )
        ;
    }
}

