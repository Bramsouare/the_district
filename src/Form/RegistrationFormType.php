<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/*###################################################################################################################################
*           ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~    CRÉATION FORMULAIRE DE CONNECTION    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
###################################################################################################################################*/

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Création champs du form
        $builder

            // Champs email
            -> add ('email')

            // Champs du mdp
            -> add ('plainPassword', PasswordType::class, 
            
                [
                    // Ne pas mapper ce champ à l'entité User
                    'mapped' => false,

                    // Désactive l'autocomplétion du mdp
                    'attr' => ['autocomplete' => 'new-password'],

                    // Contrainte
                    'constraints' => 
                    [
                        // Vérifie si le champs est vide ou pas si c'est vide alert
                        new NotBlank(

                            [
                                'message' => "Entrer un mots de passe.",
                            ]
                        ),

                        // La longueurs minimale
                        new Length(
                            
                            [
                                // La longueurs minimale est de 6 si le mdp est plus court alors alert
                                'min' => 6,

                                'minMessage' => 'La limite de caractère est de : {{ limit }}',

                                // La longueur maximum de sécurité imposer par symfony 
                                'max' => 4096,
                            ]
                        ),
                    ],
                ]
            )

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

            // Champs téléphone
            -> add ('telephone', TextType::class, 
            
                [
                    'label' => 'Téléphone',
                    'required' => true,
                ]
            )

            // Champs adresse
            -> add ('adresse', TextType::class, 
            
                [
                    'label' => 'Adresse',
                    'required' => true,
                ]
            )

            // Champs code postal
            -> add('cp', TextType::class, 
                
                [
                    'label' => 'Code Postal',
                    'required' => true,
                ]
            )

            // Champs ville
            -> add ('ville', TextType::class, 
            
                [
                    'label' => 'Ville',
                    'required' => true,
                ]
            )

            // Champs d'acceptation de contrainte
            -> add ('agreeTerms', CheckboxType::class, 

                [
                    // Ne pas mapper ce champ à l'entité User
                    'mapped' => false,

                    // Contrainte
                    'constraints' => 

                    [
                        // Si la case n'est pas cocher une alert s'affiche
                        new IsTrue(

                            [
                                'message' => "Veuillez cocher la case s'il vous plait.",
                            ]
                        ),
                    ],
                ]
            )
        ;
    }

    /*###################################################################################################################################
    *          ~~~~~~~~~~~~~~~~  OPTIONS PAR DÉFAUT DU FORMULAIRE FUSIONNER AVEC LES OPTIONS DE CRÉATIONS     ~~~~~~~~~~~~~~~~~
    ###################################################################################################################################*/

    public function configureOptions (OptionsResolver $resolver) : void
    {
        // Cette méthode permet de définir les options par défaut du formulaire
        $resolver -> setDefaults(
            
            [
                /**  les données saisies seront automatiquement transmises à une instance de la classe Utilisateur, 
                * ce qui facilite la liaison des champs du formulaire aux propriétés de l'objet Utilisateur
                */
                'data_class' => User::class,
            ]
        );
    }
}
