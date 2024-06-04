<?php

namespace App\Form;

use App\Entity\Livraison;
use App\Entity\FactureClient;
use App\Repository\LivraisonRepository;
use App\Repository\FactureClientRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LivraisonType extends AbstractType
{
    private $livraisonRepository;
 
    public function __construct(LivraisonRepository $livraisonRepository){
        $this->livraisonRepository = $livraisonRepository;

    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('num_livraison')
            ->add('date_livraison', DateType::class, [
                'label' => 'Date Livraison',
                'widget' => 'single_text',
                'required' => true
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Adresse'
                ]             
            ])
            ->add('facture', EntityType::class , [
                'class' => FactureClient::class,
                'label' => 'Facture Client',
                'placeholder' => 'Choisir une Facture',
                'required' => true,
                'choice_label' => function(FactureClient $facture){
                    return $facture->getNumeroFacture();
                },
                'query_builder' => function(FactureClientRepository $factures){
                    $livraisons = $this->livraisonRepository->findAll();
                    $query = $factures->createQueryBuilder('c');
                    for($i =0; $i < count($livraisons); $i++){
                        $query->andWhere('c.id <>'.strval($livraisons[$i]->getFacture()->getId()));
                    }
                    return $query;
                }
            ])
        ; 
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livraison::class,
        ]);
    }
}
