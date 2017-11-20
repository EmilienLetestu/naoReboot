<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 16/11/2017
 * Time: 13:45
 */

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class FilterType extends AbstractType
{
    private $token;

    public function __construct(TokenStorage $token)
    {
        $this->token = $token;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('route',ChoiceType::class,[
                'choices' => [
                    'Validés uniquement'       => 1,
                    'En attente de validation' => 2,
                ],
                'placeholder' => 'Filtrer par statut',
                'required' => false,
                'mapped'   => false
            ])
            ->add('order', ChoiceType::class,[
                'choices' => [
                    'Les plus récentes'  => 1,
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
            ])
        ;
    }
}

