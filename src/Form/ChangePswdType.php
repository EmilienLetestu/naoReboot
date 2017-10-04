<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 03/10/17
 * Time: 22:21
 */

namespace App\Form;


use App\Validators\PswdFormat;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class ChangePswdType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('currentPswd', PasswordType::class,['constraints'=>[new NotBlank(),
                                                                                new PswdFormat(),
                                                                                new Type('string'),
                                                                                ],
                                                                 'label'  => 'Mot de passe actuel',
                                                                 'mapped' => false
            ])

            ->add('pswd', PasswordType::class,['constraints'=>[new NotBlank(),
                                                                         new PswdFormat(),
                                                                         new Type('string'),
                                                                            ],
                                                          'label' => 'Nouveau mot de passe'
            ])

            ->add('confirmPswd',PasswordType::class,['constraints'=>[new NotBlank()],
                                                               'label'  => 'Confirmer le nouveau mot de passe',
                                                               'mapped' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'App\Entity\User']);
    }
}