<?php

namespace App\Controller;

use App\Repository\PlatRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogueController extends AbstractController
{
    private $categorieRepo;
    private $platRepo;

    public function __construct (CategorieRepository $categorieRepo, PlatRepository $platRepo)
    {
        $this -> categorieRepo = $categorieRepo;
        $this -> platRepo = $platRepo;
    }

    /*###################################################################################################################################
     *                   ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~    ACCUEIL CONTROLLER    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    ###################################################################################################################################*/

    #[Route ('/', name: 'app_accueil')]

    public function accueil (): Response
    {
        $categorie = $this -> categorieRepo -> findBy ( ['active' => 1], null);
        $plats = $this -> platRepo -> findBy ( ['active' => 1], null, 3);

        return $this -> render ('accueil/index.html.twig', 
        
            [
                'controller_name' => 'CatalogueController',
                'categorie' => $categorie,
                'plats' => $plats
            ]
        );
    }

    /*####################################################################################################################################
     *                ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~      CATEGORIES CONTROLLER     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    ####################################################################################################################################*/

    #[Route ('/categorie', name: 'app_categorie')]

    public function categories (): Response
    {
        $categorie = $this -> categorieRepo -> findBy ( ['active' => 1] );
        // findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
        // $categorie = $this -> categorieRepo -> findAll ();
        $plat = $this -> platRepo -> findAll ();

        return $this -> render ('categorie/index.html.twig', 

            [
                'controller_name' => 'CategorieController',
                'categorie' => $categorie,
                'plat' => $plat
            ]

        );
    }

    /*####################################################################################################################################
     *                     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~     PLATS CONTROLLER    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    ####################################################################################################################################*/

    #[Route ('/plat', name: 'app_plat')]

    public function plats(): Response
    {
        //$platRepo = $this -> platRepo -> findAll ();
        $platSale = $this -> platRepo -> findby ( ['categorie' => [4,5,9,10,11,12,13,14]], null );
        $dessert = $this -> platRepo -> findby ( ['categorie' => [49,50]], null );
        $boisson = $this -> platRepo -> findby ( ['categorie' => 51], null );

        return $this -> render ('plat/index.html.twig',

            [
                'dataSalé' => $platSale,
                'dataDessert' => $dessert,
                'dataBoisson' => $boisson

            ]

        );
    }

    /*####################################################################################################################################
     *                     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~     PLATS CLICKÉ CONTROLLER    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    ####################################################################################################################################*/


    #[Route ('/plats/{categorie_id}', name: 'app_plats')]

    public function clickPlat ($categorie_id): Response
    {
        $cardCat = $this -> categorieRepo -> find ($categorie_id);
        $plat = $cardCat -> getPlats ();

        return $this -> render ('accueil/clickCategorie.html.twig',
            
            [
                'plat' => $plat,
            ]
        );

    }

}
