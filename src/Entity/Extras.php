<?php

namespace App\Entity;

use App\Repository\ExtrasRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExtrasRepository::class)]
class Extras
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'extras')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Room $idRoom = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isPredefined = null;

    #[ORM\ManyToOne(inversedBy: 'extras')]
    private ?PredefinedExtras $idPredefinedExtras = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $customName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $customDescription = null;

    #[ORM\Column(length: 2048, nullable: true)]
    private ?string $customImage = null;

    #[ORM\Column]
    private ?float $price = null;

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

    public function isPredefined(): ?bool
    {
        return $this->isPredefined;
    }

    public function setIsPredefined(?bool $isPredefined): static
    {
        $this->isPredefined = $isPredefined;

        return $this;
    }

    public function getIdPredefinedExtras(): ?PredefinedExtras
    {
        return $this->idPredefinedExtras;
    }

    public function setIdPredefinedExtras(?PredefinedExtras $idPredefinedExtras): static
    {
        $this->idPredefinedExtras = $idPredefinedExtras;

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

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
