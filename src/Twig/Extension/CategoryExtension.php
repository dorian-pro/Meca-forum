<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\CategoryExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CategoryExtension extends AbstractExtension
{

    public function getFunctions(): array
    {
        return [
            new TwigFunction('ListVehicle', [CategoryExtensionRuntime::class, 'listVehicle']),
        ];
    }
}
