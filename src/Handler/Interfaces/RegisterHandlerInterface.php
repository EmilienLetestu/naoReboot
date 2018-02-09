<?php

/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 21:56
 */

namespace App\Handler\Interfaces;

use App\Entity\User;
use Symfony\Component\Form\FormInterface;

Interface RegisterHandlerInterface
{
    /**
     * @param FormInterface $form
     * @param User $user
     * @return mixed
     */
    public function handle(FormInterface $form, User $user);

}