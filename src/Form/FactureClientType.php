<?php

namespace App\Form;

use App\Entity\FactureClient;
use App\Entity\CommandeClient;
use App\Repository\CommandeClientRepository;
use App\Repository\FactureClientRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Doctrine\ORM\EntityManagerInterface;

class FactureClientType extends AbstractType

{   private $entityManager;
    private $factureClientRepository;
 
    public function __construct(EntityManagerInterface $entityManager, FactureClientRepository $factureClientRepository){
        $this->entityManager = $entityManager;
        $this->factureClientRepository = $factureClientRepository;

    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero_facture', TextType::class, [
                'label' => 'Numéro Facture',
                'required' => true
            ])
            ->add('date_facturation', DateType::class , [
                'label' => 'Date Facturation',
                'required' => true,
                'widget' => 'single_text'
            ])
            ->add('paiement')
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
            ->add('mode_paiement',  ChoiceType::class, [
                'label' => 'Mode paiement',
                'choices' => [
                    'Liquide' =>  "Liquide",
                    'Virement bancaire' =>  "Virement bancaire",
                    'Carte bancaire' =>  "Carte bancaire",
                    'Chèque' =>  "Chèque",
                    'Orange Money' =>  "Orange Money",
                ],
                'placeholder' => 'Choissir le mode paiement',
                'required' => false,
            ])
            /*
            ->add('commande', EntityType::class , [
                'class' => CommandeClient::class,
                'label' => 'Commande',
                'placeholder' => 'Choisir une Commande',
                'required' => true,
                'choice_label' => function(CommandeClient $commande){
                    return $commande->getCodeCommande();
                },
                'query_builder' => function(CommandeClientRepository $commande){
                    $factureClients = $this->factureClientRepository->findAll();
                    $query = $commande->createQueryBuilder('c')
                                    ->where('c.etat = 1');
                    for($i =0; $i < count($factureClients); $i++){
                        $query->andWhere('c.id <>'.strval($factureClients[$i]->getCommande()->getId()));
                    }
                    return $query;
                }
            ])
            */
            ->add('avance', NumberType::class, [
                'label' => 'Avance',
                'required' => false,
                'attr' =>[
                    'placeholder' => 'Avance'
                ]
            ])
            ->add('remise', NumberType::class, [
                'label' => 'Remise',
                'required' => false,
                'attr' =>[
                    'placeholder' => 'Remise'
                ]
            ])
        ;
    } 

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FactureClient::class,
        ]);
    }
}
