<?php

namespace App\Twig\Runtime;

use App\Repository\VehicleRepository;
use Twig\Extension\RuntimeExtensionInterface;

class CategoryExtensionRuntime implements RuntimeExtensionInterface
{
    private VehicleRepository $vehicleRepository;

    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository =  $vehicleRepository;
    }

    public function listVehicle(): array|float|int|string
    {
        return $this->vehicleRepository->AllVehicle();
    }
}
