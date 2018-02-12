<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 14:03
 */

namespace App\Action\Admin;


use App\Entity\User;
use App\Responder\Admin\Level2RequestResponder;
use Doctrine\ORM\EntityManagerInterface;

class Level2RequestAction
{
    /**
     * @var EntityManagerInterface
     */
    private $doctrine;

    /**
     * Level2RequestAction constructor.
     * @param EntityManagerInterface $doctrine
     */
    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param Level2RequestResponder $responder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Level2RequestResponder $responder)
    {
       $repository = $this->doctrine->getRepository(User::class);

       return $responder(
           $repository->findAllAccessLvl2Request(),
           'Demande d\'accès naturaliste'
       );
    }
}
