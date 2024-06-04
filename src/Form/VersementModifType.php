<?php

namespace App\Form;

use App\Entity\Versement;
use App\Entity\Banque;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class VersementModifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant', NumberType::class, [
                'label' => 'Montant de versement',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Montant'
                ]

            ])
            ->add('date_versement',DateType::class , [
                'label' => 'Date Versement',
                'required' => true,
                'widget' => 'single_text'
            ])
            ->add('type_reglement' ,ChoiceType::class, [
                'label' => 'condition paiement',
                'choices' => [
                    'Liquide' =>  "Liquide",
                    'Virement bancaire' =>  "Virement bancaire",
                    'Carte bancaire' =>  "Carte bancaire",
                    'Chèque' =>  "Chèque",
                    'Orange Money' =>  "Orange Money",
                ],
                'placeholder' => 'Choisir le type de reglement',
                'required' => false,
            ])
            ->add('delegue', TextType::class , [
                'label' => 'Délegue',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Délegue'
                ]
            ])
            ->add('emetteur_cheque', TextType::class , [
                'label' => 'Emmetteur de Chèque',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Emmetteur de Chèque'
                ]
            ])
            ->add('banque', EntityType::class , [
                'class' => Banque::class,
                'label' => 'Banque',
                'placeholder' => 'Choisir une Banque'
            ])
        ;
    }
 
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Versement::class,
        ]);
    }
}
