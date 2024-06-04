<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Nom'
                ],
                'required' => false,
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Prénom'
                ],
                'required' => false,
            ]) 
            ->add('code_client', TextType::class, [
                'label' => 'Code Client',
                'attr' => [
                    'placeholder' => 'Code Client'
                ],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => "Le code client est obligatoire"
                    ]),
                ]
            ])
            ->add('etat')
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
                'attr' => [
                    'placeholder' => 'Télephone'
                ],
                'required' => false,
            ])
            ->add('contact', TextType::class, [
                'label' => 'Contact',
                'attr' => [
                    'placeholder' => 'Contact'
                ],
                'required' => false,
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
