<?php

namespace App\Form;

use App\Entity\Fournisseur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class FournisseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code_fournisseur', TextType::class, [
                'label' => 'Code'
            ])
            ->add('societe',TextType::class, [
                'label' => 'Société',
                'label_attr' => ['class' => 'label-required'],
                'attr' => [
                    'placeholder' => 'Société'
                ],
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez entrer le nom du fournisseur"
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => true,
                'label' => 'Email',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Email'
                ],
            ])
            ->add('telephone', IntegerType::class, [
                'label' => 'Télephone',
                'label_attr' => ['class' => 'label-required'],
                'attr' => [
                    'placeholder' => 'Télephone'
                ],
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez entrer le numero de téléphone"
                    ])
                ]
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
                'label_attr' => ['class' => 'label-required'],
                'attr' => [
                    'placeholder' => 'Adresse'
                ],
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez entrer l'adresse"
                    ])
                ]
            ])
            ->add('fax', IntegerType::class, [
                'label' => 'Fax',
                'attr' => [
                    'placeholder' => 'Fax'
                ],
                'required' => false,
            ])
            ->add('etat')
            ->add('note', TextareaType::class, [
                'attr' => [
                    'rows' => 6
                ],
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fournisseur::class,
        ]);
    }
}
