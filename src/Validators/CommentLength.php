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

    public $message = "Ne peut excéder ";
    public $limit;

    public function construct($options)
    {
        return $this->limit = $options['limit'];
    }

    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return string
     */
    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}
