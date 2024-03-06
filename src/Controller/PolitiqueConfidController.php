<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PolitiqueConfidController extends AbstractController
{
    #[Route ('/politique/confid', name: 'app_politique_confid')]

    public function index (): Response
    {
        return $this -> render ('politique_confid/index.html.twig',

            [
                'controller_name' => 'PolitiqueConfidController',
            ]
        );

    }
    
}
