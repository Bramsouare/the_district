<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FinaliserController extends AbstractController
{
    #[Route('/finaliser', name: 'app_finaliser')]
    public function index(): Response
    {
        return $this->render('finaliser/index.html.twig', [
            'controller_name' => 'FinaliserController',
        ]);
    }
}
