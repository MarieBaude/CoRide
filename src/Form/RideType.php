<?php

namespace App\Form;

use App\Entity\Ride;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('departure')
            ->add('arrival')
            ->add('nbPlace')
            ->add('price')
            ->add('modelCar')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('notes')
            ->add('user')
            ->add('criteria')
            ->add('fromPlace')
            ->add('toPlace')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ride::class,
        ]);
    }
}
