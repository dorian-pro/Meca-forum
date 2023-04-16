<?php

namespace App\Twig\Runtime;

use App\Repository\VehicleRepository;
use Twig\Extension\RuntimeExtensionInterface;

class CategoryExtensionRuntime implements RuntimeExtensionInterface
{
    private VehicleRepository $vehicleRepository;

    // On injecte le repository des véhicules via le constructeur
    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository =  $vehicleRepository;
    }

    // Méthode qui renvoie la liste de tous les véhicules disponibles
    public function listVehicle(): array|float|int|string
    {
        return $this->vehicleRepository->AllVehicle();
    }
}
