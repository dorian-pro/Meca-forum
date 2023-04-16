<?php

namespace App\Entity;

use App\Repository\MultimediaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MultimediaRepository::class)]
class Multimedia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mp4Post = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mp4Message = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageComment = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagePost = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageProfile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageMessage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageAnnounce = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\ManyToOne(inversedBy: 'picture')]
    private ?Tchat $tchat = null;

    #[ORM\ManyToOne(inversedBy: 'image')]
    private ?Post $post = null;

    #[ORM\ManyToOne(inversedBy: 'image')]
    private ?Comment $comment = null;

    #[ORM\ManyToOne(inversedBy: 'image')]
    private ?Announce $announce = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMp4Post(): ?string
    {
        return $this->mp4Post;
    }

    public function setMp4Post(?string $mp4Post): self
    {
        $this->mp4Post = $mp4Post;

        return $this;
    }

    public function getMp4Message(): ?string
    {
        return $this->mp4Message;
    }

    public function setMp4Message(?string $mp4Message): self
    {
        $this->mp4Message = $mp4Message;

        return $this;
    }

    public function getImageComment(): ?string
    {
        return $this->imageComment;
    }

    public function setImageComment(?string $imageComment): self
    {
        $this->imageComment = $imageComment;

        return $this;
    }

    public function getImagePost(): ?string
    {
        return $this->imagePost;
    }

    public function setImagePost(?string $imagePost): self
    {
        $this->imagePost = $imagePost;

        return $this;
    }

    public function getImageProfile(): ?string
    {
        return $this->imageProfile;
    }

    public function setImageProfile(?string $imageProfile): self
    {
        $this->imageProfile = $imageProfile;

        return $this;
    }

    public function getImageMessage(): ?string
    {
        return $this->imageMessage;
    }

    public function setImageMessage(?string $imageMessage): self
    {
        $this->imageMessage = $imageMessage;

        return $this;
    }

    public function getImageAnnounce(): ?string
    {
        return $this->imageAnnounce;
    }

    public function setImageAnnounce(?string $imageAnnounce): self
    {
        $this->imageAnnounce = $imageAnnounce;

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

    public function getTchat(): ?Tchat
    {
        return $this->tchat;
    }

    public function setTchat(?Tchat $tchat): self
    {
        $this->tchat = $tchat;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getComment(): ?Comment
    {
        return $this->comment;
    }

    public function setComment(?Comment $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getAnnounce(): ?Announce
    {
        return $this->announce;
    }

    public function setAnnounce(?Announce $announce): self
    {
        $this->announce = $announce;

        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->getId();
    }
}
