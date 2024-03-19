<?php

namespace App\Service;

use App\Repository\PlatRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\RouterInterface;


class PanierService  extends AbstractController
{

    private $platRepo;


    public function __construct (PlatRepository $platRepo)
    {
        $this -> platRepo = $platRepo;
    }

    
    /*###############################################################################################################
    *               ~~~~~~~~~~~~~~~~~~~~~~~~~    AFFICHER LE PANIER    ~~~~~~~~~~~~~~~~~~~~~~~~~
    ###############################################################################################################*/


    public function list (Request $request)
    {
        // On récupère la session de l'utilisateur
        $session = $request -> getSession ();

        // Récupération du panier depuis la session
        $panier = $session -> get ('panier', [] );

        /*************************************************************
        *  CRÉATION DU TABLEAU PLAT + VARIABLE POUR STOCKÉ LE TOTAL
        *************************************************************/

        // initialisation du tableau pour stocker les détails des plats et du total général
        $data = [];

        $total = 0;

        foreach ($panier as $platId => $quantité)
        {
            // On récupère le plat :
            $plat = $this -> platRepo -> find ($platId);

            // On prend le prix de ce plat, et on le multiplie avec sa quantité :
            $prix = $plat -> getPrix () * $quantité; 

            // On ajoute le prix final dans le total:
            $total = $total + $prix;

            if ($plat)
            {
                // Plusieurs element:
                $data [] =

                // 1 element:
                    [             
                        'platUnite' => $plat,
                        'quantity' => $quantité,
                        'prix' => $prix,
                    ];
                //  fin element
            }

        }

        return [

            'data' => $data,
            'total' => $total,
        ];

    }


    /*#######################################################################################################################
    *               ~~~~~~~~~~~~~~~~~~~~~~~~~    AJOUTER UN PLAT AU PANIER    ~~~~~~~~~~~~~~~~~~~~~~~~~
    #######################################################################################################################*/


    public function add (Request $request) :Response
    {

        // Récupérer l'ID du plat depuis la requête
        $id = $request -> get ('id');

        // On récupère la session de l'utilisateur
        $session = $request -> getSession ();

        // $session->clear();

        // Récupération du panier depuis la session
        $panier = $session -> get ('panier', [] );

        if ($id)
        {       
            // Mettre à jour le panier dans la session
            $panier [$id] = $panier [$id] ?? 0;
 
            $panier [$id] ++;
 
            $session -> set ('panier', $panier);
         
        }
    
        return $this->redirectToRoute('app_panier');

    }


    /*######################################################################################################################
    *                ~~~~~~~~~~~~~~~~~~~~~~~~~    RETIRER UN PLAT DU PANIER    ~~~~~~~~~~~~~~~~~~~~~~~~~
    ######################################################################################################################*/


    public function remove (Request $request) 
    {
        // Récupérer l'ID du plat depuis la requête
        $id = $request -> get ('id');

        // On récupère la session de l'utilisateur
        $session = $request -> getSession ();

        // Récupération du panier depuis la session
        $panier = $session -> get ('panier', [] );

        foreach ($panier as $platId => $quantité)
        {
            // vérifie si l'ID correspond au plat à retirer
            if ($id == $platId)
            {
                // si le plat est trouver il sera reduit de 1
                $quantité --;
                
                // si la quantité du plat est à zéro 
                if ($quantité == 0)
                {
                    // alors il sera retirer complétement du panier
                    unset ($panier [$platId] );
                }
                else
                {
                    // si la quantité n'est pas à zéro il sera m.a.j
                    $panier [$platId] = $quantité;

                    // à chaque modification le panier sera m.a.j
                    $session -> set ('panier', $panier);
                }

            }

        }

        // redirection 
        return $this -> redirectToRoute (
            
            'app_panier', []
        );

    }


    /*########################################################################################################################
    *                ~~~~~~~~~~~~~~~~~~~~~~~~~    SUPPRIMER UN PLAT DU PANIER    ~~~~~~~~~~~~~~~~~~~~~~~~~
    ########################################################################################################################*/


    public function delete (Request $request, SessionInterface $session) 
    {
        // récupérer l'identifiant du plat à supprimer du panier
        $id = $request -> attributes -> get ('id');
        
        // récupérer le panier depuis la session
        $panier = $session -> get ('panier', [] );

        // si le plat exist
        if ($panier [$id] )
        {
            // alors il sera supprimer du panier
            unset ($panier [$id] );
        };

        // la session sera m.a.j aprêt modification
        $session -> set ('panier', $panier);

        // redirection
        return $this -> redirectToRoute ('app_panier');

    }

}

?>