<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 19/02/2018
 * Time: 17:27
 */

namespace App\EventListener;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class SecurityListener
{

    /**
     * @param InteractiveLoginEvent $event
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        return
            $event->getRequest()
                ->getSession()
                ->getFlashBag()
                ->add('success',
                      'Boujour ' . $event->getAuthenticationToken()->getUser()->getName().' '.$event->getAuthenticationToken()->getUser()->getSurname().' content de vous revoir !'
                )
        ;
    }

}

