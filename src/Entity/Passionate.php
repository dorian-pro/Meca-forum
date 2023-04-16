<?php

namespace App\Entity;

use App\Repository\PassionateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PassionateRepository::class)]
class Passionate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $passionate = null;

    #[ORM\ManyToOne(inversedBy: 'passionate')]
    private ?User $userPassionate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPassionate(): ?string
    {
        return $this->passionate;
    }

    public function setPassionate(string $passionate): self
    {
        $this->passionate = $passionate;

        return $this;
    }

    public function getUserPassionate(): ?User
    {
        return $this->userPassionate;
    }

    public function setUserPassionate(?User $userPassionate): self
    {
        $this->userPassionate = $userPassionate;

        return $this;
    }

    public function __toString(): string
    {
    }
}
