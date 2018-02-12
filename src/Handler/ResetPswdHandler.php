<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 07/02/2018
 * Time: 13:39
 */

namespace App\Handler;


use App\Handler\Interfaces\ResetPswdHandlerInterface;
use Symfony\Component\Form\FormInterface;

class ResetPswdHandler implements ResetPswdHandlerInterface
{
    public function handle(FormInterface $form, $user): bool
    {
        if($form->isSubmitted() && $form->isValid())
        {
            return true;
        }

        return false;
    }
}
