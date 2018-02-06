<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 14:16
 */

namespace App\Action\Admin;


use App\Entity\User;
use App\Responder\Admin\UnactivatedListResponder;
use Doctrine\ORM\EntityManagerInterface;

class UnactivatedListAction
{
    /**
     * @var EntityManagerInterface
     */
    private $doctrine;

    /**
     * UnactivatedListAction constructor.
     * @param EntityManagerInterface $doctrine
     */
    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param UnactivatedListResponder $responder
     * @return \Symfony\Component\BrowserKit\Response
     */
    public function __invoke(UnactivatedListResponder $responder)
    {
        $repository = $this->doctrine->getRepository(User::class);

        return $responder(
            $repository->findDeletableAccount('- 60 day'),
            'Compte innactifs'
        );
    }
}
