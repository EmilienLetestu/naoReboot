<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 20/11/2017
 * Time: 09:02
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder->remove('route');
    }

    public function getParent()
    {
        return FilterType::class;
    }
}
