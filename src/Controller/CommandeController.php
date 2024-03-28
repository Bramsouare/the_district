<?php

namespace App\Controller;


use App\Entity\Commande;
use App\Form\CommandeFormType;
use App\Service\PanierService;
use App\Repository\PlatRepository;
use App\Repository\UserRepository;
use App\Entity\Detail;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/*###################################################################################################################################
 *                  ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~    COMMANDE CONTROLLER    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
###################################################################################################################################*/


class CommandeController extends AbstractController
{
    private $platRepo;

    private $mailer;

    private $userRepository;

    // Injection des dépendances via le constructeur
    public function __construct (PlatRepository $platRepo, MailerInterface $mailer, UserRepository $userRepository)
    {
        $this -> platRepo = $platRepo;
        $this -> mailer = $mailer;
        $this -> userRepository = $userRepository;
    }

    #[Route ('/commande', name: 'app_commande')]

    public function index (Request $request, PlatRepository $platRepo, EntityManagerInterface $entityManager): Response
    {
        /*###############################################################
         *                    GESTION DU PANIER
        ###############################################################*/

        // Service pour le panier
        $classe = new PanierService($platRepo);

        // Récupération des données du panier
        $fonction = $classe -> list ($request);

        // Données du panier
        $data = $fonction ['data'];

        // Total du panier
        $total = $fonction ['total'];

        // Création du formulaire de commande
        $form = $this -> createForm (CommandeFormType::class);
        
        // Gestion de la soumission du formulaire
        $form -> handleRequest ($request);


        // Si le formulaire est soumis et valide
        if ($form -> isSubmitted () && $form -> isValid () ) 
        {
            /*###############################################################
            *  GESTION ET ENREGISTREMENT DE LA COMMANDE EN BASE DE DONNÉES
            ###############################################################*/

            // Récupération de l'utilisateur actuellement connecté
            $user = $this -> getUser ();

            // Création d'une nouvelle commande
            $commande = new Commande ();

            // Date actuelle
            $dateDeCommande = new DateTime ('now');

            // Date de la commande
            $commande -> setDateCommande ($dateDeCommande);

            // Total de la commande
            $commande -> setTotal ($total);

            // État de la commande 
            $commande -> setEtat (0);

            // Assignation de l'utilisateur à la commande
            $commande -> setUser ($user);

            // Persistance de la commande
            $entityManager -> persist ($commande);

            // Enregistrer en base de données
            $entityManager -> flush ();


            /*###############################################################
            *   ENREGISTREMENT DES DETAILS DE COMMANDE EN BASE DE DONNÉES                 
            ###############################################################*/

            // Récupère la session à partir de la requête HTTP actuelle
            $session = $request -> getSession ();

            // Récupère les éléments du panier de la session. S'il n'y a pas de panier dans la session, une liste vide est retournée.
            $panier = $session -> get ('panier', [] );

            // Parcourt chaque élément du panier où $id est l'identifiant du plat et $quantité est la quantité choisie.
            foreach ($panier as $id => $quantité)
            {
                // Récupère le plat correspondant à l'identifiant $id.
                $plat = $platRepo -> find ($id);
    
                // Crée une nouvelle instance de la classe Detail, qui représente un élément de commande.
                $detail = new Detail ();

                // Définit la quantité de plat pour ce détail de commande.
                $detail -> setQuantite ($quantité);

                // Associe le plat correspondant à ce détail de commande.
                $detail -> setPlat ($plat);

                // Associe la commande en cours à ce détail de commande.
                $detail -> setCommande($commande);

                // Prépare le détail de la commande à être persisté en base de données
                $entityManager -> persist ($detail);

                // Enregistre le détail de la commande en base de données.
                $entityManager -> flush ();
            }

            // Redirection 
            return $this -> redirectToRoute ('app_finaliser');
        }

        // Affichage du formulaire et du contenu du panier
        return $this -> render ('commande/index.html.twig',

            [
                'data' => $data,
                'total' => $total,
                'form' => $form,
            ]

        );

    }
    
}
