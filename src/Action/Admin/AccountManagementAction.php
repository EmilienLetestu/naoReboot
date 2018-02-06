<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 16:46
 */

namespace App\Action\Admin;


use App\Managers\UserManager;
use App\Responder\Admin\AccountManagementResponder;
use Symfony\Component\HttpFoundation\Request;

class AccountManagementAction
{
    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * AccountManagementAction constructor.
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @param Request $request
     * @param AccountManagementResponder $responder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function __invoke(Request $request, AccountManagementResponder $responder)
    {
        $action = $request->attributes->get('action');
        $id     = $request->attributes->get('id');

        $method = $action.'User';

        $action !== 'delete' ?
            $this->userManager->$method($id) :
            $this->userManager->getDelete($id, '- 60 day')
        ;


        return $responder(
            $request->headers->get('referer')
        );
    }
}