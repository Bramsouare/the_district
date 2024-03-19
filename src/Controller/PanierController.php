<?php

namespace App\Controller;

use App\Service\PanierService;
use App\Repository\PlatRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    private $platRepo;

    // Injection du PlatRepository via le constructeur
    public function __construct (PlatRepository $platRepo)
    {
        $this -> platRepo = $platRepo;
    }

    #[Route ('/panier', name: 'app_panier')]


    /*#######################################################################################################################
    *                               ~~~~~~~~~~~~~~~~~~~~~~   LE PANIER    ~~~~~~~~~~~~~~~~~~~~~
    #######################################################################################################################*/


    public function Panier (Request $request , PlatRepository $platRepo): Response
    {

        $classe = new Panierservice ($platRepo);

        $fonction = $classe -> list ($request);
        
        $data = $fonction ['data'];

        $total = $fonction ['total'];

        // Rendu de la vue du panier avec les données
        return $this -> render ('panier/afficher.html.twig',

            [
                'data' => $data,
                'total' => $total,
            ]

        );

    }

}

?>