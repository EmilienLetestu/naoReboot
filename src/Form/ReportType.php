<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 27/09/17
 * Time: 13:32
 */

namespace App\Form;

use App\Entity\Bird;
use App\Validators\CommentLength;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Type;

class ReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bird', EntityType::class, [
                            'constraints'  =>[new NotBlank()],
                            'class'        => 'App:Bird',
                            'choice_label' => function(Bird $bird){
                                return $bird->getSpeciesForForm();
                            }
            ])

            ->add('nbrOfBirds', IntegerType::class, [
                            'constraints'=>[ new Type('numeric'),
                                             new Range([
                                                 'min' => 1,
                                                 'max' => 30,
                                                 'minMessage' => 'Le nombre minimum est 1',
                                                 'maxMessage' => 'Le nombre Maximum est 30'
                                             ])
                            ],
                            'label' => 'Spécimens observés'
            ])

            ->add('addedOn', DateType::class, [
                            'label'  => 'Date',
                            'widget' => 'choice',
                            'html5'  =>  false,
                            'format' => 'dd-MM-yyyy'
            ])

            ->add('comment', TextareaType::class, [
                            'constraints' => [new CommentLength(['limit'=>300])],
                            'mapped'      => false,
                            'trim'        => true,
                            'label'       => 'Commentaire',
                            'required'    => false
            ])

            ->add('pictRef', FileType::class, [
                            'constraints' =>[ new File([
                                                'mimeTypes' => [
                                                    'image/jpeg',
                                                    'image/png'
                                                ]
                            ])
                            ],
                            'required'    => false,
                            'label'       => 'Ajouter une Image',
                            'mapped'      => false
            ])

            ->add('location', TextType::class, [
                            'label'  => 'lieu'
            ])
            ->add('satNav', HiddenType::class, [
                'constraints' =>[new NotBlank()]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data-class' => 'App\Entity\Report']);
    }
}
