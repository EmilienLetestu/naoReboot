<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 26/09/17
 * Time: 13:07
 */
namespace App\Validators;

use Symfony\Component\Validator\Constraint;


class PswdFormat extends Constraint
{
    public $message = "Le mot de passe doit contenir entre 6 et 30 caractères";

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}