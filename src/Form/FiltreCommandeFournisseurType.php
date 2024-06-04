<?php

namespace App\Form;

use App\Entity\FiltreCommandeFournisseur;
use App\Entity\Fournisseur;
use App\Repository\FournisseurRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FiltreCommandeFournisseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fournisseur',EntityType::class, [
                'class' => Fournisseur::class,
                'required' => false,
                'placeholder' => 'Choisir un Fournisseur ',
                'choice_label' => function(Fournisseur $fournisseur){
                    return $fournisseur->getCodeFournisseur().' - '.$fournisseur->getSociete();
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
            'data_class' => FiltreCommandeFournisseur::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix(){
        return "";
    }
}
