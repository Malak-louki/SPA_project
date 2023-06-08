<?php

namespace App\Entity;

use App\Repository\DogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DogRepository::class)]
class Dog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 255)]
    protected ?string $name = null;

    #[ORM\Column]
    protected ?bool $isLof = null;

    #[ORM\Column(type: Types::TEXT)]
    protected ?string $background = null;

    #[ORM\Column]
    protected ?bool $isPetFriendly = null;

    #[ORM\Column(type: Types::TEXT)]
    protected ?string $description = null;

    #[ORM\Column]
    protected ?bool $isAdopted = null;

    #[ORM\ManyToOne(inversedBy: 'dogs')]
    #[ORM\JoinColumn(nullable: false)]
    protected ?Announcement $announcement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function isIsLof(): ?bool
    {
        return $this->isLof;
    }

    public function setIsLof(bool $isLof): self
    {
        $this->isLof = $isLof;

        return $this;
    }

    public function getBackground(): ?string
    {
        return $this->background;
    }

    public function setBackground(string $background): self
    {
        $this->background = $background;

        return $this;
    }

    public function isIsPetFriendly(): ?bool
    {
        return $this->isPetFriendly;
    }

    public function setIsPetFriendly(bool $isPetFriendly): self
    {
        $this->isPetFriendly = $isPetFriendly;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isIsAdopted(): ?bool
    {
        return $this->isAdopted;
    }

    public function setIsAdopted(bool $isAdopted): self
    {
        $this->isAdopted = $isAdopted;

        return $this;
    }

    public function getAnnouncement(): ?Announcement
    {
        return $this->announcement;
    }

    public function setAnnouncement(?Announcement $announcement): self
    {
        $this->announcement = $announcement;

        return $this;
    }
}
