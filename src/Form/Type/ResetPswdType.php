<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 27/09/17
 * Time: 09:28
 */

namespace App\Form\Type;


use App\Validators\PswdFormat;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class ResetPswdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pswd', PasswordType::class, [
                                'constraints' => [
                                    new NotBlank(),
                                    new PswdFormat(),
                                    new Type('string'),
                                    new Length([
                                        'min'        => 6,
                                        'max'        => 30,
                                        'minMessage' => 'Le mot de passe doit être composé de 6 à 30 caractères',
                                        'maxMessage' => 'Le mot de passe doit être composé de 6 à 30 caractères'
                                    ])
                                ],
                                'required' => true,
                                'label' => 'Nouveau mot de passe'
            ])

            ->add('confirmPswd', PasswordType::class, [
                                'constraints' => [
                                    new NotBlank(),
                                    new Type('string')
                                ],
                                'required' => true,
                                'mapped'   => false,
                                'label'    => 'Confirmer le mot de passe'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
       return $resolver->setDefaults(['data-class', 'App\Entity\User']);
    }

}

