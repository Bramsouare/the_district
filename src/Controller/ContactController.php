<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route ('/contact', name: 'app_contact')]
    
    public function index (Request $request): Response
    {
        // Crée un formulaire à partir de la classe ContactType
        $form = $this -> createForm (ContactType::class);

        $form -> handleRequest ($request);

        // Vérifie si le formulaire a été soumis et est valide
        if ($form -> isSubmitted() && $form -> isValid() ) 
        {
            // Redirige vers la route 'contact_success'
            return $this -> redirectToRoute ('contact_success');
        }

        return $this -> render ('contact/index.html.twig', 
        
            [
                // Crée une vue du formulaire
                'form' => $form -> createView (),
            ]
        );
        
    }
    public function contactSuccess (): Response
    {
        return $this -> render ('contact/success.html.twig');
    }
   
}
