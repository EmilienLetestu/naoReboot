<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 03/10/17
 * Time: 23:01
 */

namespace App\Services;


use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class ProfileBuilder
{
    private $doctrine;
    private $session;
    private $token;
    private $tools;

    /**
     * ProfileBuilder constructor.
     * @param EntityManager $doctrine
     * @param Session $session
     * @param TokenStorage $token
     * @param Tools $tools
     */
    public function __construct(
        EntityManager $doctrine,
        Session       $session,
        TokenStorage  $token,
        Tools         $tools
    )
    {
        $this->doctrine = $doctrine;
        $this->session  = $session;
        $this->token    = $token;
        $this->tools    = $tools;
    }

    public function buildOwnerProfile()
    {
        //fetch id and createdOn into tokenStorage
        $user = $this->token->getToken()->getUser();
        $id   = $user->getId();
        $date = $user->getCreatedOn()->format('d-m-Y');
        $role = $user->getRoles();

        //get account type
        $accountType = $this->tools->displayAccountType($role);

        return [
            $date,
            $accountType
        ];
    }
}