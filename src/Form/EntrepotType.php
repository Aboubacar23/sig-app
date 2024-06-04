<?php

namespace App\Form;

use App\Entity\Entrepot;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class EntrepotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle',TextType::class, [
                'label' => 'libelle',
                'attr' => [
                    'placeholder' => 'libelle'
                ],
                'required' => true,
            ])
            ->add('pays', CountryType::class, [
                'placeholder' => 'Choisir un pays',
                'required' => false,
                'label'=> 'Pays'
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'Ville'
                ],
                'required' => false,
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'placeholder' => 'Adresse'
                ],
                'required' => false,
            ])
            ->add('telephone', IntegerType::class, [
                'label' => 'Télephone',
                'attr' => [
                    'placeholder' => 'Télephone'
                ],
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'rows' => 4,
                    'placeholder' => 'Description'
                ],
                'required' => false,
            ])
            ->add('etat',CheckboxType::class, [
                'label' => "Etat de L'entrepot",
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entrepot::class,
        ]);
    }
}
