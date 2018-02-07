<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 07/02/2018
 * Time: 14:04
 */

namespace App\Handler\Inter;


use App\Entity\User;
use Symfony\Component\Form\FormInterface;

Interface AskResetHandlerInterface
{
    /**
     * @param FormInterface $form
     * @param User $user
     * @return mixed
     */
    public function handle(FormInterface $form, User $user);

}