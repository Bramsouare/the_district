<?php 
namespace App\EventSubscriber;


use App\Entity\Commande;
use Doctrine\ORM\Events;
use Symfony\Component\Mime\Email;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class CommandeSubscriber implements EventSubscriber
{
    // Propriété pour stocker le service MailerInterface
    private $mailer;

    // Propriété pour stocker le service Security
    private $security;

    // Déclaration du constructeur prenant MailerInterface et Security
    public Function __construct(MailerInterface $mailer , Security $security)
    {
        // Initialisation de la propriété $mailer avec le service MailerInterface
        $this -> mailer = $mailer;

        // Initialisation de la propriété $security avec le service Security
        $this -> security = $security;
    }

    /*##################################################################
    #  DÉCLARATION DE LA MÉTHODE GETSUBSCRIBEREVENTS
    ###################################################################*/ 
    public  function getSubscribedEvents()
    {
        return 
        [
            // Événement onFlush de Doctrine ORM
            Events::onFlush,
        ];
    }

    /*##############################################################################
    #  DÉCLARATION DE LA MÉTHODE ONFLUSH PRENANT LIFECYCLEEVENTARGS COMME ARGUMENT #
    ##############################################################################*/ 

    public function onFlush (OnFlushEventArgs $args)
    {
        // Construit l'e-mail de confirmation
        $email = (new Email ())

        // Expéditeur
        -> from (new Address('souare@gmail.com', 'souare') )

        // Destinataire
        -> to ($this -> security -> getUser () -> getUserIdentifier () )

        // Object
        -> subject ("Confirmer de commande")

        // Text 
        -> text ('Félicitations, votre commande a bien été envoyée.')

        // Contenue HTML de l'email
        -> html ('');

        // Envoie l'e-mail en utilisant le service MailerInterface
        $this -> mailer -> send ($email);
    }

}

