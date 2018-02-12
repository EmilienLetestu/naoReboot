<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 27/09/17
 * Time: 09:11
 */

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class AskResetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->add('email', EmailType::class, [
                            'constraints' => [new NotBlank(),
                                              new Email(['message' => 'Ceci n\'est pas un email valide'])]
           ])
       ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
       return $resolver->setDefaults(['data-class' =>'App\Entity\User']);
    }
}
