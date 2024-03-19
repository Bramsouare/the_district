<?php

namespace App\Controller;

use App\Form\CommandeFormType;
use App\Service\PanierService;
use App\Repository\PlatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CommandeController extends AbstractController
{
    private $platRepo;

    // Injection du PlatRepository via le constructeur
    public function __construct (PlatRepository $platRepo)
    {
        $this -> platRepo = $platRepo;
    }

    #[Route ('/commande', name: 'app_commande')]

    public function index (Request $request, PlatRepository $platRepo, EntityManagerInterface $entityManager): Response
    {
        $classe = new PanierService($platRepo);

        $fonction = $classe -> list ($request);

        $data = $fonction ['data'];

        $total = $fonction ['total'];

        $form = $this -> createForm (CommandeFormType::class);
        
        $form -> handleRequest ($request);

        return $this -> render ('commande/index.html.twig',

            [
                'data' => $data,
                'total' => $total,
                'form' => $form,
            ]

        );

    }
    
}
