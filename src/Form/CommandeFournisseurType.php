<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Fournisseur;
use App\Entity\CommandeFournisseur;
use App\Repository\ProduitRepository;
use Symfony\Component\Form\AbstractType;
use App\Repository\FournisseurRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommandeFournisseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero_commande')
            ->add('date_commande', DateType::class, [
                'label' => 'Date de Commande',
                'widget' => 'single_text',
                'required' => true
            ])
            ->add('paiement_date', DateType::class, [
                'label' => 'Date de paiement',
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('paiement_mode',   ChoiceType::class, [
                'label' => 'Mode paiement',
                'choices' => [
                    'LIQUIDE' =>  "LIQUIDE",
                    'VIREMENT BANCAIRE' =>  "VIREMENT BANCAIRE",
                    'CARTE BANCAIRE' =>  "CARTE BANCAIRE",
                    'CHÈQUE' =>  "CHÈQUE",
                    'ORANGE MONEY' =>  "ORANGE MONEY",
                    'TRANSFERT LOCAL' =>  "TRANSFERT LOCAL",
                ],
                'placeholder' => 'Choisir le mode paiement',
                'required' => false,
            ])
            ->add('expedition_mode',  ChoiceType::class, [
                'label' => 'Mode Expédition',
                'choices' => [
                    'CARGO' =>  "CARGO",
                    'NAVIRE' =>  "NAVIRE",
                    'DHL'=> 'DHL',
                    'Autres' =>  "Autres",
                ],
                'placeholder' => 'Choisir le mode Expédition',
                'required' => false,
            ])
            ->add('note',TextareaType::class, [
                'attr' => [
                    'rows' => 6
                ],
                'required' => false
            ])
            ->add('fournisseur', EntityType::class, [
                'class' => Fournisseur::class,
                'required' => true,
                'placeholder' => 'Choisir un Fournisseur ',
                'choice_label' => function(Fournisseur $fournisseur){
                    return $fournisseur->getCodeFournisseur().' - '.$fournisseur->getSociete();
                },
                'query_builder' => function(FournisseurRepository $fournisseurRepository){
                    return $fournisseurRepository->createQueryBuilder('c')->where('c.etat = 1');

                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CommandeFournisseur::class,
        ]);
    }
}
