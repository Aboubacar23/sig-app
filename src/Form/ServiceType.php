<?php

namespace App\Form;

use App\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class , [
                'label' => 'Libelle',
                'attr' => [
                    'placeholder' => 'Libelle'
                ]
            ])
            ->add('periodique')
            ->add('prix', NumberType::class , [
                'label' => 'Prix Service',
                'attr' => [
                    'placeholder' => 'Prix Service'
                ]
            ])
            ->add('taxe', NumberType::class , [
                'label' => 'Taxe du Service',
                'attr' => [
                    'placeholder' => 'taxe'
                ]
            ])
            ->add('reference', TextType::class , [
                'label' => 'Réference',
                'attr' => [
                    'placeholder' => 'Réference'
                ]
            ])
            ->add('desciption', TextareaType::class , [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Description',
                    'rows' => 6,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
