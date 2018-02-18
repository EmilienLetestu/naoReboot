<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 18/02/2018
 * Time: 13:51
 */

namespace App\Validators;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class WordLimitValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $count = str_word_count(strip_tags($value));
        $limit = $constraint->getLimit();

        if($count > $limit)
        {
            $this->context->buildViolation($constraint->message.$limit.' mots')
                ->addViolation()
            ;
        }
    }
}
