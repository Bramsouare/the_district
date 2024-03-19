<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\User;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('livraison')

            ->add('facturation')

            ->add('agreeTerms', CheckboxType::class, 

                [
                    // non mappé a l'entité et les information ne sont enregistrer
                    'mapped' => false,
                    'label' => "Les deux adresse sont bien identique",

                    // contrainte de validation
                    'constraints' => 

                    [
                        // si la case n'est pas cochée, afficher une alerte
                        new IsTrue(
                            
                            [
                                'message' => 'veuillez cocher la case s\'il vous plait',
                            ]
                        ),
                    ],
                ]
            )

            -> add ('payement1', CheckboxType::class,)

            -> add ('payement2', CheckboxType::class,)
        ;
    }

    public function configureOptions (OptionsResolver $resolver) : void
    {

        $resolver->setDefaults(
            
            [

                'data_class' => Commande::class,
            ]
        );
    }
}
