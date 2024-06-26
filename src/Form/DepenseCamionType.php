<?php

namespace App\Form;

use App\Entity\DepenseCamion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DepenseCamionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('banque',ChoiceType::class, [
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
            ->add('montant')
            ->add('date_depense', DateType::class, [
                'label' => 'Date Dépense',
                'widget' => 'single_text'
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
            ->add('numero_cheque',TextType::class, [
                'label' => 'Numéro Chèque',
                'attr' => [
                    'placeholder' => 'numero chèque'
                ]
            ])
            ->add('ordre_de',TextType::class, [
                'label' => 'Ordre De',
                'attr' => [
                    'placeholder' => 'Ordre De'
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
            'data_class' => DepenseCamion::class,
        ]);
    }
}
