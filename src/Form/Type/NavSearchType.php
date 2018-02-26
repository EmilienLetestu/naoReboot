<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 16/11/2017
 * Time: 10:09
 */

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class NavSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->add('search', SearchType::class, [
               'constraints' => [new NotBlank()
               ],
               'mapped'      => false
           ])
           ->add('submit', SubmitType::class,[
                 'label' => ' ',
                 'attr'  =>['class' => "fa fa-search"]

           ])
       ;
    }
}

