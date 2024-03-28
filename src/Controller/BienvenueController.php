<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BienvenueController extends AbstractController
{
    private $categorieRepo;

    public function __construct (CategorieRepository $categorieRepo)
    {
        $this -> categorieRepo = $categorieRepo;
    }

    #[Route ('/bienvenue', name: 'app_bienvenue') ]

    public function index () : Response
    {
        return $this -> render ('bienvenue/index.html.twig', 
        
            [
                'controller_name' => 'BienvenueController',
            ]
        );
    }
    
}
