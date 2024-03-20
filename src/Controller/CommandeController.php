<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeFormType;
use App\Service\PanierService;
use App\Repository\PlatRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\TextUI\Command;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CommandeController extends AbstractController
{
    private $platRepo;

    private $mailer;

    // Injection du PlatRepository via le constructeur
    public function __construct (PlatRepository $platRepo, MailerInterface $mailer)
    {
        $this -> platRepo = $platRepo;
        $this -> mailer = $mailer;
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

        if ($form -> isSubmitted () && $form -> isValid () ) 
        {
            return $this -> redirectToRoute ('app_finaliser');
        }

        return $this -> render ('commande/index.html.twig',

            [
                'data' => $data,
                'total' => $total,
                'form' => $form,
            ]

        );

    }
    
}
