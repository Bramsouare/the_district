<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

###############################################################################
#    ~~~~~~     MÉTHODES EST FONCTIONNALITÉ DU NOYAU DE SYMFONY     ~~~~~~    #  
###############################################################################
class Kernel extends BaseKernel
{
    # Implémente certaines fonctionnalités de base du noyau de l'application Symfony.
    use MicroKernelTrait;
}
