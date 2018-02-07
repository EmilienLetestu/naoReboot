<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 07/02/2018
 * Time: 14:38
 */

namespace App\Handler\Inter;


use Symfony\Component\Form\FormInterface;

interface UpdateHomeHandlerInterface
{
    public function handle(FormInterface $form):bool;

}