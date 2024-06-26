<?php

namespace App\Form;

use App\Entity\RecetteCamion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecetteCamionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant_transport', NumberType::class, [
                'label' => 'Montant Transport',
                'attr' => [
                    'placeholder' => '0.00 GNF'
                ]
            ])
            ->add('mode_paiement',ChoiceType::class, [
                'label' => 'Mode de Paiement',
                'placeholder' => 'Mode de Paiement',
                'required' => false,
                'choices' => [
                    'CHÈQUE' =>  "CHÈQUE",
                    'LIQUIDE' =>  "LIQUIDE",
                    'VIREMENT BANCAIRE' =>  "VIREMENT BANCAIRE",
                    'AUTRES' => "AUTRES",
                ],
            ])
            ->add('date_recette', DateType::class, [
                'label' => 'Date Récette',
                'widget' => 'single_text'
            ])
            ->add('depart', TextType::class, [
                'label' => 'Départ',
                'attr' => [
                    'placeholder' => 'Point de départ'
                ]
            ])
            ->add('banque', ChoiceType::class, [
                'label' => 'Banque',
                'placeholder' => 'Choisir une banque',
                'choices' => [
                    'CAISSE' => 'CAISSE',
                    'ACCESS BANQUE' => 'ACCESS BANQUE',
                    'BCI' => 'BCI',
                    'UBA' => 'UBA',
                    'VISTAGUI' => 'VISTAGUI',
                    'SGBG' => 'SGBG'
                ]
            ])
            ->add('numero_cheque', TextType::class, [
                'label' => 'Numéro Chèque',
                'attr' => [
                    'placeholder' => 'numero chèque'
                ]
            ])
            ->add('destination',TextType::class, [
                'label' => 'Déstination',
                'attr' => [
                    'placeholder' => 'Déstination'
                ]
            ])
            ->add('type_tc', ChoiceType::class, [
                'label' => 'Type TC',
                'placeholder' => 'Choisir un type',
                'choices' => [
                    '20 DRY' => '20 DRY',
                    '40 DRY' => '40 DRY',
                    '45 DRY' => '45 DRY',
                    'VEHICULE' => 'VEHICULE',
                    'AUTRES' => 'AUTRES',
                ]
            ])
            ->add('observation',TextareaType::class, [
                'label' => 'Observation',
                'required' => false,
                'attr' => [
                    'rows' => 8,
                ]
            ])
           // ->add('camion')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RecetteCamion::class,
        ]);
    }
}
