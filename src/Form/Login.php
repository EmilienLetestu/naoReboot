<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 28/09/17
 * Time: 16:29
 */

namespace App\Form;


use App\Validators\PswdFormat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class Login extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username',EmailType::class,[
                                'constraints'=>[ new NotBlank(),
                                                 new Email(['message' => 'Ceci n\'est pas un emazil valide']),
                                ],
                                'label' => 'E-mail'
            ])
            ->add('_password', PasswordType::class,[
                                'constraints'=>[new NotBlank(),
                                                new PswdFormat(),
                                                new Type('string'),
                                                new Length([
                                                    'min'        => 6,
                                                    'max'        => 30,
                                                    'minMessage' => 'Le mot de passe doit être composé de 6 à 30 caractères',
                                                    'maxMessage' => 'Le mot de passe doit être composé de 6 à 30 caractères'
                                                ])
                                ],
                                'label' => 'Mot de passe'
            ])
        ;
    }
}
