<?php

namespace App\Form;

use App\Entity\Plats;
use App\Entity\SubType;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlatsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('Prix')
            ->add('type', EntityType::class , [
                'class' => Type::class ,
                'choice_label' =>'name'
            ])
            ->add('subtype', EntityType::class , [
                'class' => SubType::class ,
                'choice_label' =>'name'
            ])
            ->add('submit', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Plats::class,
        ]);
    }
}
