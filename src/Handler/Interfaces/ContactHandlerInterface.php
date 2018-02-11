<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 22:37
 */

namespace App\Handler\Interfaces;




use Symfony\Component\Form\FormInterface;

interface ContactHandlerInterface
{
    /**
     * @param FormInterface $form
     * @return bool
     */
    public function handle(FormInterface $form):bool;
}