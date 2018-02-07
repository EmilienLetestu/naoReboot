<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 07/02/2018
 * Time: 13:39
 */

namespace App\Handler\Inter;


use Symfony\Component\Form\FormInterface;

Interface ResetPswdHandlerInterface
{
    public function handle(FormInterface $form, $user) :bool ;
}