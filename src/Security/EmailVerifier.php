<?php

namespace App\Security;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use Psr\Log\LoggerInterface;

/*##############################################################################################################    
*        ~~~~~~~~~~~~~~~~~~~~~~~~~~      VERIFICATIONS EMAIL     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
##############################################################################################################*/

class EmailVerifier
{

    /*******************************************************************    
    *               DEPENDANCE QUI IMPLÉMENTE DES CLASSES
    *******************************************************************/

    public function __construct(

        private VerifyEmailHelperInterface $verifyEmailHelper,
        private MailerInterface $mailer,
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger 
    ) 
    {}


    /*##############################################################################################################    
    *           ~~~~~~~~~~~~~~~      ENVOIE D'EMAIL DE CONFIRMATION ET VÉRIFICATION     ~~~~~~~~~~~~~~~
    ##############################################################################################################*/


    public function sendEmailConfirmation(string $verifyEmailRouteName, UserInterface $user, TemplatedEmail $email): void
    {
        // Contient composants de la signature et la génère
        $signatureComponents = $this -> verifyEmailHelper -> generateSignature(

            // Route du lien l'ors du clique
            $verifyEmailRouteName,

            // Id user pour l'identifier
            $user -> getId (),

            // Email de l'user utilisé
            $user -> getEmail (),

            // 
            ['id' => $user -> getId () ]

        );

        // Récupère le contexte actuel
        $context = $email -> getContext ();

        // Ajoute l'url signer l'ors de la verification email
        $context ['signedUrl'] = $signatureComponents -> getSignedUrl ();

        // Traduit les messages d'expiration dans template email
        $context ['expiresAtMessageKey'] = $signatureComponents -> getExpirationMessageKey ();

        // Inclue données d'expiration du mail
        $context ['expiresAtMessageData'] = $signatureComponents -> getExpirationMessageData ();

        // M.a.j email
        $email -> context ($context);

        try
        {
            // Envoie email
            $this -> mailer -> send ($email);

            // Enregistrer un message de journalisation si l'e-mail est envoyé avec succès
            $this -> logger -> info ('E-mail de confirmation envoyé avec succès.');
        }
        catch (\Exception $e)
        {
            // Gérer les erreurs d'envoi d'e-mail
            $this -> logger -> error ("Erreur lors de l'envoi de l'e-mail de confirmation : " . $e -> getMessage ());

            // Répéter l'exception pour qu'elle soit gérée à un niveau supérieur si nécessaire
            throw $e;
        }

    }

    /**  Gestion confirmations email
    * @throws VerifyEmailExceptionInterface
    */


    /*##############################################################################################################    
    *           ~~~~~~~~~~~~~~~~~~~~~~~~      CONFIRMATION UTILISATEUR     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    ##############################################################################################################*/


    public function handleEmailConfirmation (Request $request, UserInterface $user): void
    {
        // Vérification, url, user, email, validité signature
        $this -> verifyEmailHelper -> validateEmailConfirmation ($request -> getUri (), $user -> getId (), $user -> getEmail () );

        // M.a.j de isVerified
        $user -> setIsVerified (true);

        // M.a.j base de données
        $this -> entityManager -> persist ($user);

        // Enregistrer dans la base de données
        $this -> entityManager -> flush ();
    }
}
