<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Commande;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class CommandeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            -> add ('facturation', TextType::class,
                
                [
                    'required' => false,
                ]
            )

            -> add ('livraison', TextType::class, 
            
                [
                    'required' => false,
                ]
            )

            -> add ('memeAdresse', CheckboxType::class, 

                [
                    // non mappé a l'entité et les information ne sont enregistrer
                    'mapped' => false,
                    'required' => false,
                ]
            )

            -> add ('payement1', CheckboxType::class,

                [
                    'required' => false,
                ]
                
            )

            -> add ('payement2', CheckboxType::class,
            
                [
                    'required' => false,
                ]
            
            )

            -> add ('agree', CheckboxType::class, 

                [
                    // non mappé a l'entité et les information ne sont enregistrer
                    'mapped' => false,
                    
                    // contrainte de validation
                    'constraints' => 

                    [
                        // si la case n'est pas cochée, afficher une alerte
                        new IsTrue(
                            
                            [
                                'message' => 'Veuillez accepter le C.G.U.',
                            ]
                        ),
                    ],
                ]
            )
        ;
    }

    public function configureOptions (OptionsResolver $resolver) : void
    {

        $resolver -> setDefaults(
            
            [
                // 'data_class' => Commande::class,
            ]
        );
    }
}
