<?php

namespace App\Service;

use App\Repository\PlatRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierService
{

    private $platRepo;

    public function __construct (PlatRepository $platRepo)
    {
        $this -> platRepo = $platRepo;
    }

    
    /***************************************************************************************************************
    *               ~~~~~~~~~~~~~~~~~~~~~~~~~    AFFICHER LE PANIER    ~~~~~~~~~~~~~~~~~~~~~~~~~
    ***************************************************************************************************************/


    public function list (Request $request)
    {
        // récupération de la session a partire de la requête en cours
        $session = $request -> getSession ();
        // répupération de la variable à partir de la session
        $panier = $session -> get ('panier', [] );

        /*************************************************************
        *  CRÉATION DU TABLEAU PLAT + VARIABLE POUR STOCKÉ LE TOTAL
        *************************************************************/

        // initialisation du tableau pour stocker les détails des plats et du total général
        $tableauPlats = [];
        $total = 0;

       
        foreach ($panier as $id => $quantité)
        {
            // récupération des détails du plat à partir de son ID
            $platUnique = $this -> platRepo -> find ($id);
            // calcul du prix total pour ce plat
            $prix = $platUnique -> getPrix () * $quantité; 
            // mise à jour du total général du panier
            $total = $total + $prix;

            // stockage des détails du plat dans le tableau
            if ($platUnique)
            {
                $tableauPlats [] = 
                [
                    'platU' => $platUnique,
                    'quantity' => $quantité,
                    'prix' => $prix,
                ];

            }

        }

        // retourne les détails des plats dans le panier et le total général
        return
        [
            'plats' => $tableauPlats,
            'total' => $total,
        ];

    }


    /***************************************************************************************************************
    *               ~~~~~~~~~~~~~~~~~~~~~~~~~    AJOUTER UN PLAT AU PANIER    ~~~~~~~~~~~~~~~~~~~~~~~~~
    ***************************************************************************************************************/


    public function add (Request $request, SessionInterface $session) 
    {
        // vérifie si un ID est présent dans les attributs de la requête
        if ($request -> attributes -> get ('id'))
        {
            // récupère l'ID du plat à ajouter au panier
            $id = $request -> attributes -> get ('id');
            // récupère le panier actuel à partir de la session
            $panier = $session -> get ('panier', [] );
            
            // récupèration de la quantité actuelle du plat dans le panier. Sinon, il initialise la quantité à 0
            $panier [$id] = $panier [$id] ?? 0;
            // incrémente la quantité du plat dans le panier
            $panier [$id] ++;

            // m.a.j du panier dans la session
            $session -> set ('panier',$panier);
        }
    
    }


    /***************************************************************************************************************
    *               ~~~~~~~~~~~~~~~~~~~~~~~~~    RETIRER UN PLAT DU PANIER    ~~~~~~~~~~~~~~~~~~~~~~~~~
    ***************************************************************************************************************/


    public function remove (Request $request, SessionInterface $session) 
    {
        // récupérer l'identifiant du plat à supprimer du panier
        $id = $request -> attributes -> get ('id');
        // récupère le panier actuel à partir de la session
        $panier = $session -> get ('panier', [] );

        foreach ($panier as $ids => $quantité)
        {
            // vérifie si l'ID correspond au plat à retirer
            if ($id == $ids)
            {
                // si le plat est trouver il sera reduit de 1
                $quantité --;
                
                // si la quantité du plat est à zéro 
                if ($quantité == 0)
                {
                    // alors il sera retirer complétement du panier
                    unset ($panier [$ids] );
                }
                else
                {
                    // si la quantité n'est pas à zéro il sera m.a.j
                    $panier [$ids] = $quantité;
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


    /***************************************************************************************************************
    *               ~~~~~~~~~~~~~~~~~~~~~~~~~    SUPPRIMER UN PLAT DU PANIER    ~~~~~~~~~~~~~~~~~~~~~~~~~
    ***************************************************************************************************************/


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








    // /***************************************************************************************************************
    //  *                                  ENREGISTREMENT PANIER BASE DE DONNÉES
    // ***************************************************************************************************************/

    // public function ajouterAuPanier (int $platId): void
    // {
    //     // récupérer le plat avec id
    //     $plat = $this -> entityManager -> getRepository (Plat::class) -> find ($platId);

    //     if (!$plat)
    //     {
    //         throw new \InvalidArgumentException("Plat avec l'ID $platId n'existe pas.");
    //     }

    //     /// récupérer le panier de l'utilisateur (ou créer un nouveau panier si nécessaire)
    //     $panier = $this -> getPanier ();

    //     // ajouter le plat au panier
    //     $panier -> addPanierBd ($plat);

    //     // Enregistrer l'entrée dans la base de données
    //     $this -> entityManager -> persist ($panier);
    //     $this -> entityManager -> flush ();

        
    // }

    // /***************************************************************************************************************
    //  *                                  SUPPRESSION PLAT PANIER BASE DE DONNÉES
    // ***************************************************************************************************************/

    // public function supprimerDuPanier (int $platId): void
    // {
    //     // récupérer le plat avec l'ID
    //     $plat = $this -> entityManager -> getRepository (Plat::class) -> find ($platId);

    //     if (!$plat) 
    //     {
    //         throw new \InvalidArgumentException ("Plat avec l'ID $platId n'existe pas.");
    //     }

    //     // récupérer le panier de l'utilisateur
    //     $panier = $this -> getPanier ();

    //     // retirer le plat du panier
    //     $panier -> removePanierBd ($plat);

    //     // enregistrer les changements dans la base de données
    //     $this -> entityManager -> flush ();

    // }

    // /***************************************************************************************************************
    //  *                                          RÉCUPÉRATION DU PANIER 
    // ***************************************************************************************************************/

    // public function listerContenuPanier (): array
    // {

    //     // récupérer le panier de l'utilisateur
    //     $panier = $this -> getPanier ();

    //     // Récupérer tous les plats dans le panier
    //     return $this -> $panier -> getPanierBd () -> toArray ();
    // }

    // private function getPanier (): Panier
    // {
    //     return new Panier ();
    // }

}

?>