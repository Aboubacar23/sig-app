<?php

namespace App\Form;

use App\Entity\LCommandeClient;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class LCommandeClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantite',IntegerType::class, [
                'label' => 'Quantite',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Quantite'
                ]
            ])
            ->add('tva',NumberType::class, [
                'label' => 'tva',
                'required' => false,
                'attr' => [
                    'placeholder' => 'TVA'
                ]
            ])
            ->add('remise',NumberType::class, [
                'label' => 'Remise',
                'required' => false,
                'attr' => [ 
                    'placeholder' => 'Remise'
                ]
            ])
            ->add('produit', EntityType::class, [
                'class' => Produit::class,
                'required' => false,
                'placeholder' => 'Choisir un produit',
                'choice_label' => function(Produit $produit){
                   // return $produit->getCodeProduit().' - '.$produit->getLibelle();
                    return $produit->getLibelle();
                },
                'query_builder' => function(ProduitRepository $produitRepository){
                    return $produitRepository->createQueryBuilder('p')->where("p.etat = 'Vente'")
                        ->where("p.quantite <> 0");
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LCommandeClient::class,
        ]);
    }
} 
