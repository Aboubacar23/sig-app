<?php

namespace App\Form;

use App\Entity\CommandeClient;
use App\Entity\Client;
use App\Entity\Produit;
use App\Entity\Service;
use App\Repository\ProduitRepository;
use App\Repository\ServiceRepository;
use App\Repository\ClientRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CommandeClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder 
            ->add('code_commande', TextType::class, [
                'label' => 'Code Commande',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Code Commande'
                ]
            ])
            ->add('numero_reference', TextType::class, [
                'label' => 'Numéro Reference',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Numero reference'
                ]
            ])
            ->add('date_commande', DateType::class, [
                'label' => 'Date Commande',
                'widget' => 'single_text',
                'required' => true
            ])
           /* ->add('type_commande', ChoiceType::class, [
                'label' => 'Type Commande',
                'choices' => [
                    'Commande Client' =>  "Commande Client",
                    'Devis Commercial' =>  "Devis Commercial",
                ],
                'placeholder' => 'Choissir le Type Commande',
                'required' => false,
            ])
            */
            //->add('etat')
            ->add('note', TextareaType::class, [
                'label'=> 'Note de la commande',
                'attr' => [
                    'rows' => 4,
                ],
                'required' => false
            ]) 
            ->add('paiement_date', DateType::class, [
                'label' => 'Paiement Date',
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('reception_date', DateType::class, [
                'label' => 'Reception date',
                'widget' => 'single_text',
                'required' => false
            ])
         /*   ->add('produit', EntityType::class, [
                'class' => Produit::class,
                'required' => false,
                'placeholder' => 'Choisir un produit',
                'choice_label' => function(Produit $produit){
                    return $produit->getCodeProduit().' - '.$produit->getLibelle();
                },
                'query_builder' => function(ProduitRepository $produitRepository){
                    return $produitRepository->createQueryBuilder('p')->where("p.etat = 'Vente'");
                }
            ])
            ->add('service', EntityType::class, [
                'class' => Service::class,
                'placeholder' => 'Choisir un Service',
                'required' => false,
                'choice_label' => function(Service $service){
                    return $service->getLibelle();
                },
                'query_builder' => function(ServiceRepository $serviceRepository){
                    return $serviceRepository->createQueryBuilder('s');

                }
            ])
            */
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'required' => true,
                'placeholder' => 'Choisir un Client ',
                'choice_label' => function(Client $client){
                    return $client->getCodeClient().' - '.$client->getNom().' - '.$client->getPrenom();
                },
                'query_builder' => function(ClientRepository $clientRepository){
                    return $clientRepository->createQueryBuilder('c')->where('c.etat = 1');

                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CommandeClient::class,
        ]);
    }
}
