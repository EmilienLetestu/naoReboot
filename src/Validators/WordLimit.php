<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 18/02/2018
 * Time: 13:46
 */

namespace App\Validators;

use Symfony\Component\Validator\Constraint;

class WordLimit extends Constraint
{
    /**
     * @var
     */
    public $limit;

    /**
     * @var string
     */
    public $message = 'Texte limité à ';

    /**
     * WordLimit constructor.
     * @param null $options
     */
    public function __construct($options)
    {
        if($options !== null)
        {
            $this->limit = $options['limit'];
        }
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
