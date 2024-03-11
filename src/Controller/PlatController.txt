<?php

namespace App\Controller;

use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlatController extends AbstractController
{
    private $platRepo;

    public function __construct (PlatRepository $platRepo)
    {
        $this -> platRepo = $platRepo;
    }

    #[Route ('/plat', name: 'app_plat')]

    public function index (): Response
    {
        //$platRepo = $this -> platRepo -> findAll ();
        $platSale = $this -> platRepo -> findby ( ['Categorie' => [4,5,9,10,11,12,13,14]], null );
        $dessert = $this -> platRepo -> findby ( ['Categorie' => [43,44]], null );
        $boisson = $this -> platRepo -> findby ( ['Categorie' => 45], null );


        return $this -> render ('plat/index.html.twig',

            [
                'dataSalé' => $platSale,
                'dataDessert' => $dessert,
                'dataBoisson' => $boisson

            ]

        );

    }
    
}
