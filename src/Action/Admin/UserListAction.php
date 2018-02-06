<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 11:08
 */

namespace App\Action\Admin;


use App\Entity\Report;
use App\Entity\User;
use App\Responder\Admin\UserListResponder;
use Doctrine\ORM\EntityManagerInterface;

class UserListAction
{
    /**
     * @var EntityManagerInterface
     */
    private $doctrine;

    /**
     * UserListAction constructor.
     * @param EntityManagerInterface $doctrine
     */
    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param UserListResponder $responder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(UserListResponder $responder)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $repo = $this->doctrine->getRepository(Report::class);

        //get all activated account
        $userList = $repository->findAllActivated();

        foreach ($userList as $user)
        {
            $idList[] = $user->getId();
        }

        foreach ($idList as $id)
        {
            $report[] = $repo->findUserLastPublication($id);
        }

        Return $responder(
            $repository->findAllActivated(),
            $report,
            'Liste des membres'
        );
    }
}
