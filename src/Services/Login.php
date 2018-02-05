<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 02/10/17
 * Time: 19:16
 */

namespace App\Services;

use App\Entity\Star;
use App\Entity\User;
use App\Entity\Validation;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class Login
{
    private $authCheck;
    private $session;
    private $token;
    private $doctrine;

    /**
     * Login constructor.
     * @param AuthorizationChecker $authCheck
     * @param Session $session
     * @param TokenStorage $token
     * @param EntityManager $doctrine
     */
    public function  __construct(
        AuthorizationChecker $authCheck,
        Session              $session,
        TokenStorage         $token,
        EntityManager        $doctrine

    )
    {
        $this->authCheck  = $authCheck;
        $this->session    = $session;
        $this->token      = $token;
        $this->doctrine   = $doctrine;
    }

    /**
     * fetch all stars and validations added by user,
     * store them into session
     * @return null
     */
    public function getUserHistory()
    {
        if(!$this->authCheck->isGranted('ROLE_USER') || $this->session->has('star'))
        {

            return null;
        }
        $user = $this->token->getToken()->getUser();
        $star = $this->doctrine->getRepository(Star::class)
            ->findStarAddedBy($user->getId());
        ;
        $this->session->set('star', $star);

        if($this->authCheck->isGranted('ROLE_VALIDATOR'))
        {
            $validation = $this->doctrine->getRepository(Validation::class)
                ->findValidationAddedBy($user->getId())
            ;
            $this->session->set('validation', $validation);
        }
    }
}
