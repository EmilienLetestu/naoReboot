<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 22:37
 */

namespace App\Handler\Inter;




use Symfony\Component\Form\FormInterface;

interface ContactHandlerInterface
{
    /**
     * @param FormInterface $form
     * @return mixed
     */
    public function handle(FormInterface $form);
}