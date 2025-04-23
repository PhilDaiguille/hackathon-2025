<?php

namespace App\Entity;

use App\Repository\NegociationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\NegotiationStatus;

#[ORM\Entity(repositoryClass: NegociationRepository::class)]
class Negociation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'negociation', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Booking $idBooking = null;

    #[ORM\Column]
    private ?float $newPrice = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $responseDeadline = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: 'string', enumType: NegotiationStatus::class)]
    private NegotiationStatus $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdBooking(): ?Booking
    {
        return $this->idBooking;
    }

    public function setIdBooking(Booking $idBooking): static
    {
        $this->idBooking = $idBooking;

        return $this;
    }

    public function getNewPrice(): ?float
    {
        return $this->newPrice;
    }

    public function setNewPrice(float $newPrice): static
    {
        $this->newPrice = $newPrice;

        return $this;
    }

    public function getResponseDeadline(): ?\DateTimeInterface
    {
        return $this->responseDeadline;
    }

    public function setResponseDeadline(\DateTimeInterface $responseDeadline): static
    {
        $this->responseDeadline = $responseDeadline;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getStatus(): NegotiationStatus
    {
        return $this->status;
    }

    public function setStatus(NegotiationStatus $status): self
    {
        $this->status = $status;
        return $this;
    }
}
