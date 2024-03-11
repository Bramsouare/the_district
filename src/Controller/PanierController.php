<?php

namespace App\Controller;

use App\Service\PanierService;
use App\Repository\PlatRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class PanierController extends AbstractController
{
    private $platRepo;

    public function __construct (PlatRepository $platRepo)
    {
        $this -> platRepo = $platRepo;
    }

    #[Route ('/panier', name: 'app_panier')]


    /*************************************************************************************************************************
    *                               ~~~~~~~~~~~~~~~~~~~~~~   LE PANIER    ~~~~~~~~~~~~~~~~~~~~~
    *************************************************************************************************************************/


    public function Panier (Request $request, PlatRepository $platRepo): Response
    {

        $id = $request -> get ('id');
        // $plat = $this->platRepo -> find ($id);
        $plat= $this->platRepo->findOneBy(['id'=>$id], null);

        // $sessions = $request -> getSession ();
        // $sessions -> set ('id', $id);

        // $idSession = $sessions -> get ('id');

        
        return $this -> render ('panier/afficher.html.twig',

            [
                'plat' => $plat,
                
                
            ]

        );

    }












    /*************************************************************************************************************************************
     *                                                      AJOUTER AU PANIER
    *************************************************************************************************************************************/
    
    // #[Route ('/panier', name: 'app_panier')]

    // public function ajouterAuPanier (Request $request, Plat $plat): Response
    // {
    //     // ajouter le plat au panier 
    //     $this -> panierService -> ajouterAuPanier ($plat -> getId ());

    //     // alert 
    //     $this -> addFlash('success', 'Le plat a été ajouté au panier avec succès.');

    //     // redirection
    //     return $this -> redirectToRoute ('panier/afficher.html.twig');
    // }
    
    // /*************************************************************************************************************************************
    //  *                                                      SUPPRIMER DU PANIER
    // *************************************************************************************************************************************/

    // #[Route ('/panier', name: 'app_panier')]

    // public function supprimerDuPanier (Request $request, Plat $plat) : Response 
    // {
    //     // supprimer le plat du panier
    //     $this -> panierService -> supprimerDuPanier ($plat -> getId ());

    //     // alert
    //     $this -> addFlash ('success', 'Le plat a été supprimé du panier avec succès.');

    //     // affiche la page
    //     return $this -> redirectToRoute ('panier/afficher.html.twig');
    // }

    // /*************************************************************************************************************************************
    //  *                                                     AFFICHAGE DU PANIER
    // *************************************************************************************************************************************/

    // #[Route ('/panier', name: 'app_panier')]

    // public function afficherPanier (): Response
    // {
    //     $contenuePanier = $this -> panierService -> listerContenuPanier ();

    //     return $this -> render ('panier/afficher.html.twig', 

    //         [
    //             'contenuePanier' => $contenuePanier,
    //         ]
    //     );
    // }

}


?>