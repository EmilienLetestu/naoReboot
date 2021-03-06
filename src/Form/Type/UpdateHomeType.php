<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 05/10/17
 * Time: 22:32
 */

namespace App\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;


class UpdateHomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('species', TextType::class,[
                                'constraints'=>[ new NotBlank()],
                                'label' => 'Nom de l\'espèce',
                                'required' => false
            ])
            ->add('picture', FileType::class, [
                                'constraints' =>[ new File([
                                                    'mimeTypes' => [
                                                        'image/jpeg',
                                                        'image/png'
                                                    ]
                                ])
                                ],
                                'required'   => false,
                                'label'      => 'Modifier l\'image',

            ])
            ->add('pictNum', HiddenType::class)
        ;

    }
}

