<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 16/11/2017
 * Time: 10:09
 */

namespace App\Form;


use App\Entity\Bird;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder->add('bird', EntityType::class, [
           'class' => 'App:Bird',
           'choice_label' => function(Bird $bird){
            return $bird->getSpeciesNameOnly();
           },
           'placeholder' => 'Rechercher une espèce'
       ]);
    }
}
