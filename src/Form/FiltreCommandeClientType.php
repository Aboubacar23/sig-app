<?php

namespace App\Form;

use App\Entity\FiltreCommandeClient;
use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FiltreCommandeClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Client',EntityType::class, [
                'class' => Client::class,
                'required' => false,
                'placeholder' => 'Choisir un client ',
                'choice_label' => function(Client $client){
                    return $client->getCodeClient().' - '.$client->getNom().' - '.$client->getPrenom();
                },
            ])
            ->add('periode_min',DateType::class , [
                'label' => 'Date Min',
                'required' => false,
                'widget' => 'single_text'
            ])
            ->add('periode_max',DateType::class , [
                'label' => 'Date Max',
                'required' => false,
                'widget' => 'single_text'
            ]) 
        ;
    } 

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FiltreCommandeClient::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix(){
        return "";
    }
}
