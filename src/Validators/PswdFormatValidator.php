<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 26/09/17
 * Time: 13:08
 */
namespace App\Validators;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PswdFormatValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        //should contains a mix of letters and numbers
        $madeOf   = preg_match('#^(?=.*[a-zA-z])(?=.*\d)#',$value);
        //detect if a number is repeated more than 3 times in a row
        $noSeries = preg_match('#(\d)\1{3}#', $value);
        //check length
        $length = strlen($value);

        if(!$madeOf || $noSeries || $length > 30)
        {
            $this->context->buildViolation($constraint->message)
                ->addViolation()
            ;
        }

    }
}
