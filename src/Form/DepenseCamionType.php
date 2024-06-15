<?php

namespace App\Form;

use App\Entity\DepenseCamion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DepenseCamionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('banque')
            ->add('montant')
            ->add('date_depense')
            ->add('mode_paiement')
            ->add('numero_cheque')
            ->add('ordre_de')
            ->add('observation')
            ->add('camion')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DepenseCamion::class,
        ]);
    }
}
