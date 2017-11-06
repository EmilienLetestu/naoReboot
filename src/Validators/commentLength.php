<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 27/09/17
 * Time: 13:58
 */

namespace App\Validators;

use Symfony\Component\Validator\Constraint;

class CommentLength extends Constraint
{
    /**
     * @var string
     */
    public $message = "Votre commentaire ne peut excèder 300 caractères";

    /**
     * @return string
     */
    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}
