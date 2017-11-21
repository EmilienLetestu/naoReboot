<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 26/09/17
 * Time: 09:51
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

use App\Validators\PswdFormat;

class RegisterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                                'constraints'=>[ new NotBlank(),
                                                 new Type('string'),
                                                 new Length([
                                                     'min'        => 3,
                                                     'max'        => 30,
                                                     'minMessage' => 'Le prénom doit comporter 3 lettres au minimun',
                                                     'maxMessage' => 'Le prénom ne peut excéder 30 lettres'
                                                 ])
                                ],
                                'label' => 'Prénom'
            ])

            ->add('surname', TextType::class,[
                                'constraints'=>[ new NotBlank(),
                                                 new Type('string'),
                                                 new Length([
                                                     'min'        => 3,
                                                     'max'        => 30,
                                                     'minMessage' => 'Le prénom doit comporter 3 lettres au minimun',
                                                     'maxMessage' => 'Le prénom ne peut excéder 30 lettres'
                                                 ]),
                                ],
                                'label' => 'Nom'
            ])

            ->add('email', EmailType::class,[
                                'constraints'=>[ new NotBlank(),
                                                 new Email(['message' => 'Ceci n\'est pas un email valide']),
                                ],
                                'label' => 'E-mail'
            ])

            ->add('pswd', PasswordType::class,[
                                'constraints'=>[ new NotBlank(),
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

            ->add('accessLevel', ChoiceType::class,[
                                'label'   => 'Vous êtes',
                                'choices' => ['un passioné d\'ornithologie' => 1,
                                              'un professionnel'            => 2
                                ]
            ])

            ->add('termsAgreement', CheckboxType::class,[
                                'label'     => 'J\'accepte les conditions générales d\'utilisation',
                                'required'  => true,
                                'mapped'    => false
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'App\Entity\User']);
    }
}
