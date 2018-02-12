<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 27/09/17
 * Time: 13:58
 */

namespace App\Validators;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CommentLengthValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if(strlen($value) > $constraint->getLimit())
        {
            $this->context->buildViolation($constraint
                          ->message.$constraint->getLimit().'caractères')
                          ->addViolation()
            ;
        }
    }
}

