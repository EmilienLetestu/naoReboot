<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 16/11/2017
 * Time: 13:45
 */

namespace App\Form;

use App\Repository\ReportRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('order', ChoiceType::class,[
                                'choices' => [  'Les plus récentes'  => 1,
                                                'les plus anciennes' => 2,
                                                'A-Z'                => 3
                                ],
                                'placeholder' => 'Ordre d\'affichage',
                                'required' => false,
                                'mapped'   => false
            ])
            ->add('bird', EntityType::class, [
                                'class' => 'App:Report',
                                'choice_label' => 'bird.getSpeciesForForm',
                                'choice_value' => 'bird.id',
                                'placeholder' => 'Rechercher une espèce',
                                'required' => false,
                                'query_builder' => function(ReportRepository $repository){
                                    return $repository->findSpeciesForForm(1);
                                }
            ])
        ;
    }
}

