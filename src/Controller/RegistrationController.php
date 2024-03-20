<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;


/*###################################################################################################################################
*                   ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~    INSCRIPTION CONTROLLER    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
###################################################################################################################################*/


class RegistrationController extends AbstractController
{
    // Déclaration de la dépendance
    private EmailVerifier $emailVerifier;

    // Instancié emailVerifier
    public function __construct(EmailVerifier $emailVerifier)
    {
        $this -> emailVerifier = $emailVerifier;
    }

    // Route pour inscription
    #[Route('/register', name: 'app_register')]


    /*#########################################################################################
     *         ~~~~~~~~~~~~~~~~~     FONCTION D'ENREGISTREMENT    ~~~~~~~~~~~~~~~~~~
    #########################################################################################*/


    public function register (Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        // Nouvelle instance de user
        $user = new User();

        // Création form associer à user
        $form = $this -> createForm (RegistrationFormType::class, $user);

        // Gestion soumission form
        $form -> handleRequest($request);

        // Si le form est soumis et valide
        if ($form -> isSubmitted () && $form -> isValid() ) 
        {

            // Mdp stocké de manière sécuriser (haché)
            $user -> setPassword(

                $userPasswordHasher -> hashPassword(

                    // L'entité ou le mdp sera associé
                    $user,
                    // Récupère le mdp non haché saisies par l'utilisateur
                    $form -> get ('plainPassword') -> getData ()
                )
            );

            // Ajout du client à l'utilisateur
            $user -> setRoles (['ROLE_CLIENT']);


            // Prendre les paramètre en cours...
            $entityManager -> persist ($user);
            // Enregistrement en base de données
            $entityManager -> flush ();

            // Envoi d'un e-mail de confirmation d'inscription à l'user
            $this -> emailVerifier -> sendEmailConfirmation ('app_verify_email', $user,

                // New instance TemplateEmail
                (new TemplatedEmail () )

                    // Expéditeur
                    -> from (new Address ('souare@gmail.com', 'souare') )

                    // Destinataire
                    -> to ($user -> getEmail () )

                    // Object
                    -> subject ("Confirmer le email s'il vous plait")

                    // Utilise le contenue html comme un lien par exemple
                    -> htmlTemplate ('registration/confirmation_email.html.twig')
            );

            // Redirection après l'inscription
            return $this -> redirectToRoute ('app_accueil');
        }

        // Rendu du formulaire d'inscription
        return $this -> render ('registration/register.html.twig', 
        
            [
                'registrationForm' => $form,
            ]
        );
    }

    // Route pour la vérification de l'e-mail
    #[Route('/verify/email', name: 'app_verify_email')]


    /*#########################################################################################
     *       ~~~~~~~~~~~~~~~~~     FONCTION DE VÉRIFICATION EMAIL    ~~~~~~~~~~~~~~~~~~
    #########################################################################################*/


    public function verifyUserEmail (Request $request, TranslatorInterface $translator, UserRepository $userRepository): Response
    {
        // Récupération de l'id de user dans le requête
        $id = $request -> query -> get('id');

        // Dans le cas ou le id est introuvable redirection
        if (null === $id) 
        {
            return $this -> redirectToRoute ('app_register');
        }

        // Recherche de l'user dans la base de données
        $user = $userRepository -> find ($id);

        // Dans le cas ou le $user est introuvable redirection
        if (null === $user) 
        {
            return $this -> redirectToRoute ('app_register');
        }

        // Gestion de la confirmation de l'e-mail de l'utilisateur
        try 
        {
            // Cette methode valider le lien de confirmation envoyé par e-mail. Elle marque l'utilisateur comme vérifié 
            $this -> emailVerifier -> handleEmailConfirmation ($request, $user);
        }

        catch (VerifyEmailExceptionInterface $exception) 
        {
            // Affiche des notifications ou des messages à l'utilisateur puis redirection
            $this -> addFlash ('verify_email_error', $translator -> trans ($exception -> getReason (), [], 'VerifyEmailBundle') );

            return $this -> redirectToRoute ('app_register');
        }

        // Envoi d'un message flash de succès à l'user et redirection
        $this -> addFlash ('success', "L'email a bien été vérifier");

        return $this -> redirectToRoute ('app_register');
    }
}
