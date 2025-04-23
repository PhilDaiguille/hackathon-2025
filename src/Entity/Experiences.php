<?php

namespace App\Entity;

use App\Repository\ExperiencesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExperiencesRepository::class)]
class Experiences
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'experiences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Room $idRoom = null;

    #[ORM\ManyToOne(inversedBy: 'experiences')]
    private ?PredefinedExtras $idPredefinedExtra = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isPredefined = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $customName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $customDescription = null;

    #[ORM\Column(length: 2048, nullable: true)]
    private ?string $customImage = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdRoom(): ?Room
    {
        return $this->idRoom;
    }

    public function setIdRoom(?Room $idRoom): static
    {
        $this->idRoom = $idRoom;

        return $this;
    }

    public function getIdPredefinedExtra(): ?PredefinedExtras
    {
        return $this->idPredefinedExtra;
    }

    public function setIdPredefinedExtra(?PredefinedExtras $idPredefinedExtra): static
    {
        $this->idPredefinedExtra = $idPredefinedExtra;

        return $this;
    }

    public function isPredefined(): ?bool
    {
        return $this->isPredefined;
    }

    public function setIsPredefined(?bool $isPredefined): static
    {
        $this->isPredefined = $isPredefined;

        return $this;
    }

    public function getCustomName(): ?string
    {
        return $this->customName;
    }

    public function setCustomName(?string $customName): static
    {
        $this->customName = $customName;

        return $this;
    }

    public function getCustomDescription(): ?string
    {
        return $this->customDescription;
    }

    public function setCustomDescription(?string $customDescription): static
    {
        $this->customDescription = $customDescription;

        return $this;
    }

    public function getCustomImage(): ?string
    {
        return $this->customImage;
    }

    public function setCustomImage(?string $customImage): static
    {
        $this->customImage = $customImage;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
