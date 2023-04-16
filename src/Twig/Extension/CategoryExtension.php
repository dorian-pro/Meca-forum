<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\CategoryExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CategoryExtension extends AbstractExtension
{

    /**
     * Retourne une liste des fonctions disponibles dans l'extension
     *
     * @return array La liste des fonctions
     */
    public function getFunctions(): array
    {
        return [
            // Déclare une nouvelle fonction Twig "ListVehicle" qui appelle la méthode "listVehicle"
            // de la classe CategoryExtensionRuntime
            new TwigFunction('ListVehicle', [CategoryExtensionRuntime::class, 'listVehicle']),
        ];
    }
}