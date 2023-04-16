<?php

namespace App\Entity;

use App\Repository\TchatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TchatRepository::class)]
class Tchat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $messageSend = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $messageReceive = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $sendTo = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $receiveTo = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\OneToMany(mappedBy: 'tchat', targetEntity: Multimedia::class)]
    private Collection $image;

    public function __construct()
    {
        $this->image = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessageSend(): ?string
    {
        return $this->messageSend;
    }

    public function setMessageSend(?string $messageSend): self
    {
        $this->messageSend = $messageSend;

        return $this;
    }

    public function getMessageReceive(): ?string
    {
        return $this->messageReceive;
    }

    public function setMessageReceive(?string $messageReceive): self
    {
        $this->messageReceive = $messageReceive;

        return $this;
    }

    public function getSendTo(): ?\DateTimeInterface
    {
        return $this->sendTo;
    }

    public function setSendTo(\DateTimeInterface $sendTo): self
    {
        $this->sendTo = $sendTo;

        return $this;
    }

    public function getReceiveTo(): ?\DateTimeInterface
    {
        return $this->receiveTo;
    }

    public function setReceiveTo(\DateTimeInterface $receiveTo): self
    {
        $this->receiveTo = $receiveTo;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection<int, Multimedia>
     */
    public function getPicture(): Collection
    {
        return $this->image;
    }

    public function addPicture(Multimedia $image): self
    {
        if (!$this->image->contains($image)) {
            $this->image->add($image);
            $image->setTchat($this);
        }

        return $this;
    }

    public function removePicture(Multimedia $picture): self
    {
        if ($this->picture->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getTchat() === $this) {
                $picture->setTchat(null);
            }
        }

        return $this;
    }
}
