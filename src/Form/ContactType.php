<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            // Champs nom
            -> add ('nom', TextType::class, 

                [
                    'label' => 'Nom',
                    'required' => true,
                ]
            )

            // Champs prénom
            -> add ('prenom', TextType::class, 

                [
                    'label' => 'Prénom',
                    'required' => true,
                ]
            )

            // Champs email
            -> add ('email', TextType::class, 
            
                [
                    'label' => 'E-mail',
                    'required' => true,
                ]
            )

            // Champs téléphone
            -> add ('telephone', TextType::class, 
            
                [
                    'label' => 'Téléphone',
                    'required' => true,
                ]
            )
            // Champs message
            -> add ('message', TextareaType::class, 
            
                [
                    'label' => 'Message',
                    'required' => true,
                ]
            )
        ;
    }

    public function configureOptions (OptionsResolver $resolver): void
    {
        $resolver -> setDefaults(
            
            [
                // Configure your form options here
            ]
        );
    }
}
