<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Fournisseur;
use App\Entity\Entrepot;
use App\Entity\Tva;
use App\Repository\FournisseurRepository;
use App\Repository\EntrepotRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code_produit', TextType::class,[
                'label' => 'Code Produit',
                 'required' => true,
            ])
            ->add('libelle',TextType::class,[
                'label' => 'Libelle Produit',
                 'required' => true,
                 'attr' => [
                 'placeholder' => 'Libelle'
                 ]
             ])
            ->add('prix_achat', NumberType::class, [
                'label'=> "Prix d'achat (GNF)",
                'required' => true,
                'attr' => [
                    'placeholder' => " Prix Achat (GNF)"
                ]
            ])
            ->add('prix_vente', NumberType::class, [
                'label'=> "Prix de Vente (GNF)",
                'required' => true,
                'attr' => [
                    'placeholder' => " Prix Vente (GNF)"
                ]
            ])
            ->add('key_produit')
            ->add('image', FileType::class, [
                'disabled' => false,
                'label' => ' Image',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5000000k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Veuillez choisir une image png, jpg ou jpeg',
                    ])
                ]
            ]) 
            ->add('stock_initial',IntegerType::class, [
                'label' => 'Stock initial',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Stock initial'
                ]
            ])
            ->add('quantite',IntegerType::class, [
                'label' => 'Quantite',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Quantite'
                ]
            ])
            ->add('poids',IntegerType::class, [
                'label' => 'Poids (g)',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Poids (g)'
                ]
            ])
            // ->add('taux',NumberType::class, [
            //     'label' => 'Taux devise',
            //     'required' => false,
            //     'attr' => [
            //         'placeholder' => 'Taux'
            //     ]

            // ])
            ->add('volume',IntegerType::class, [
                'label' => 'Volume (m3)',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Volume (m3)'
                ]
            ])
            ->add('couleur', TextType::class,[
                'label' => 'Couleur',
                 'required' => false,
                 'attr' => [
                 'placeholder' => 'Couleur'
             ]
             ])
            ->add('etat', ChoiceType::class, [
                'label' => 'Etat',
                'choices' => [
                    'Vente' =>  "Vente",
                    'OR Vente' =>  "OR Vente",
                ],
                'placeholder' => 'Choissir le Etat',
                'required' => false,
            ])
            ->add('reference', TextType::class,[
                'label' => 'Réference',
                 'required' => false,
                 'attr' => [
                 'placeholder' => 'Réference'
             ]
            ])
            ->add('desciption', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'rows' => 6,
                ]
            ])
            ->add('fournisseur', EntityType::class, [
                'label' =>'Fournisseur',
                'class' => Fournisseur::class,
                'placeholder' => 'Choissir un fournisseur',
                'required' =>true,
                'choice_label' => function(Fournisseur $fournisseur){
                    return $fournisseur->getCodeFournisseur().' + '.$fournisseur->getSociete();
                },
                'query_builder' => function(FournisseurRepository $fournisseurRepository){
                    return $fournisseurRepository->createQueryBuilder('f')->where('f.etat = 1'); 
                }
            ])
            ->add('entrepot',EntityType::class, [
                'label' =>'Entrepot',
                'class' => Entrepot::class,
                'placeholder' => 'Choissir un entrepot',
                'required' =>true,
                'choice_label' => function(Entrepot $entrepot){
                    return $entrepot->getLibelle();
                },
                'query_builder' => function(EntrepotRepository $entrepotRepository){
                    return $entrepotRepository->createQueryBuilder('e')->where('e.etat = 1');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
