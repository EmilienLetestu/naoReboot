<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 23/11/2017
 * Time: 14:17
 */

namespace App\Form\Type;


use App\Validators\CommentLength;
use App\Validators\WordLimit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->add('fullname',TextType::class,[
                                'constraints' => [ new NotBlank(),
                                                   new Length([
                                                    'min'        => 10,
                                                    'max'        => 45,
                                                    'minMessage' => 'Ce champ doit comporter 10 cararctères au minimun',
                                                    'maxMessage' => 'Ce champ ne peut excéder 45 caractères'
                                                  ])
                                ],
                                'attr' => [
                                    'placeholder' => 'Nom et Prénom'
                                ]
           ])
           ->add('email', EmailType::class,[
                                'constraints'=>[ new NotBlank(),
                                                 new Email(['message' => 'Ceci n\'est pas un email valide']),
                                ],
                                'attr' => [
                                    'placeholder' => 'Votre email'
                                ]
           ])
           ->add('subject', TextType::class,[
                                'constraints' => [ new Length([
                                                  'min'        => 5,
                                                  'max'        => 50,
                                                  'minMessage' => 'Ce champ doit comporter 5 cararctères au minimun',
                                                  'maxMessage' => 'Ce champ ne peut excéder 45 caractères'
                                                  ])
                                ],
                                'required'    => false,
                                'attr' => [
                                    'placeholder' => 'Sujet de votre message'
    ]

           ])
           ->add('message', TextareaType::class, [
                                'constraints'   => [new WordLimit(['limit'=>100])],
                                'mapped'        => false,
                                'trim'          => true
           ])
       ;
    }
}

