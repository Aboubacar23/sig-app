<?php

namespace App\Form;

use App\Entity\Camion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CamionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero_camion', TextType::class, [
                'label' => 'Numéro Camion',
                'attr' => [
                    'placeholder' => 'numéro'
                ]
            ])
            ->add('chauffeur',TextType::class, [
                'label' => 'Chauffeur',
                'attr' => [
                    'placeholder' => 'nom chaffeur'
                ]
            ])
            ->add('model',TextType::class, [
                'label' => 'Model',
                'attr' => [
                    'placeholder' => 'model du camion'
                ]
            ])
            ->add('marque',TextType::class, [
                'label' => 'Marque',
                'attr' => [
                    'placeholder' => 'marque'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Camion::class,
        ]);
    }
}
