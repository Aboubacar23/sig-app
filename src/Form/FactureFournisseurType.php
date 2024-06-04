<?php

namespace App\Form;

use App\Entity\CommandeFournisseur;
use App\Entity\FactureFournisseur;
use App\Repository\CommandeFournisseurRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FactureFournisseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero_facture', TextType::class, [
                'label' => 'Numéro Facture',
                'attr' => [
                    'placeholder' => 'Numéro Facture'
                ],
                'required' => true
            ])
            ->add('reference_paiement', TextType::class, [
                'label' => 'Réference paiement',
                'attr' => [
                    'placeholder' => 'Réference paiement'
                ],
                'required' => ''
            ])
            ->add('date_limite_paiement', DateType::class , [
                'label' => 'Date Limite paiement',
                'required' => true,
                'widget' => 'single_text'
            ])
            ->add('etat_paiement')
            ->add('condition_paiement',  ChoiceType::class, [
                'label' => 'condition paiement',
                'choices' => [
                    'A la réception' =>  "A la réception",
                    '30 jours' =>  "30 jours",
                    '30 jours fin du mois' =>  "30 jours fin du mois",
                    '60 jours' =>  "60 jours",
                    '60 jours fin du mois' =>  "60 jours fin du mois",
                    'A la commande' =>  "A la commande",
                    'A livraison' =>  "A livraison",
                ],
                'placeholder' => 'Choissir le condition paiement',
                'required' => false,
            ])
            ->add('date_facturation', DateType::class , [
                'label' => 'Date Facturation',
                'required' => true,
                'widget' => 'single_text'
            ])
            ->add('note',TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'rows' => 6,
                ]
            ])
            ->add('commande', EntityType::class , [
                'class' => CommandeFournisseur::class,
                'label' => 'Commande',
                'placeholder' => 'Choisir une Commande',
                'required' => true,
                'choice_label' => function(CommandeFournisseur $commande){
                    return $commande->getNumeroCommande();
                },
                'query_builder' => function(CommandeFournisseurRepository $commande){
                    return $commande->createQueryBuilder('c')
                                    ->where('c.etat = 1');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FactureFournisseur::class,
        ]);
    }
}
