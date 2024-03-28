<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/*###############################################################################################
    ~~~~~~~~~~~~~~~~~~~~~~~~~      CONNECTION CONTROLLER     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
###############################################################################################*/

class ConnectionController extends AbstractController
{
    // Définit une route pour la méthode login
    #[Route (path: '/connection', name: 'app_connection') ]

    /*###############################################################################################
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~      PARAMÈTRES DE CONNECTION     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    ###############################################################################################*/

    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Récupère toute erreur de connexion survenue lors de la dernière tentative de connexion
        $error = $authenticationUtils -> getLastAuthenticationError ();

        // Récupère le dernier nom d'utilisateur saisi par l'utilisateur
        $lastUsername = $authenticationUtils -> getLastUsername ();

        // Rend la vue en passant les variables 'last_username' et 'error' pour être affichées dans le modèle
        return $this -> render ('connection/index.html.twig', 
        
            [
                'last_username' => $lastUsername,
                'error' => $error,
            ]
        );
    }

    // Définit une route pour la méthode logout 
    #[Route (path: '/logout', name: 'app_logout') ]

    public function logout (): void
    {
        // Lance une exception pour indiquer que :
        throw new \LogicException ('Cette méthode peut rester vide car elle sera interceptée par le pare-feu de déconnexion de Symfony');
    }

    public function deconnection (Request $request): RedirectResponse
    {
        $request -> getSession () -> invalidate ();
        
        return $this -> redirectToRoute ('app_accueil');
    }
}
