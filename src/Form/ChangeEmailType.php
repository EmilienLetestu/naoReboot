<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 03/10/17
 * Time: 22:48
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangeEmailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->add('email', EmailType::class,['constraints'=>[new NotBlank(),
                                                                      new Email(['message' => 'Ceci n\'est pas un email valide']),
                                                                      ],
                                                       'label' => 'Nouvell adresse email'
           ])

           ->add('confirmEmail', EmailType::class,['constraints'=>[new NotBlank()],
                                                              'label'  => 'confirmer l\'adresse',
                                                              'mapped' => false

           ])
       ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
       $resolver->setDefaults(['data_class'=>'App/Entity/User']);
    }
}