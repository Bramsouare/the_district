<?php

namespace App\Controller;

use App\Repository\PlatRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccueilController extends AbstractController
{
    private $categorieRepo;
    private $platRepo;

    public function __construct (CategorieRepository $categorieRepo, PlatRepository $platRepo)
    {
        $this -> categorieRepo = $categorieRepo;
        $this -> platRepo = $platRepo;
    }

    #[Route ('/accueil', name: 'app_accueil')]

    public function index (): Response
    {
        $categorie = $this -> categorieRepo -> findBy ( ['active' => 1], null );
        $plat = $this -> platRepo -> findby ( ['active' => 1], null, 3 );

        return $this -> render ('accueil/index.html.twig', 

            [
                'controller_name' => 'AccueilController',

                'categorie' => $categorie,
                
                'plat' => $plat
            ]
            
        );

    }

}
