<?php

namespace App\Controller;
use App\Repository\PlatRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategorieController extends AbstractController
{
    private $categorieRepo;
    private $platRepo;

    public function __construct (CategorieRepository $categorieRepo, PlatRepository $platRepo)
    {
        $this -> categorieRepo = $categorieRepo;
        $this -> platRepo = $platRepo;
    }

    #[Route ('/categorie', name: 'app_categorie')]

    public function index (): Response
    {
       
        $categorie = $this -> categorieRepo -> findBy ( ['active' => 1], null );
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
    
}
