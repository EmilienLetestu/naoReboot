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
    public $message = "Ne peut excéder ";

    /**
     * @var
     */
    public $limit;

    /**
     * @param $options
     * @return mixed
     */
    public function __construct($options)
    {
        return $this->limit = $options['limit'];
    }

    /**
     * @return mixed
     */
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

