<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OfferRepository::class)]
class Offer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'offers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hotel $idHotel = null;

    #[ORM\OneToOne(inversedBy: 'offer', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Room $idRoom = null;

    #[ORM\Column(nullable: true)]
    private ?int $acceptanceThreshold = null;

    #[ORM\Column(nullable: true)]
    private ?int $refusalThreshold = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $availableFrom = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $availableUntil = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToOne(mappedBy: 'idOffer', cascade: ['persist', 'remove'])]
    private ?Booking $booking = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdHotel(): ?Hotel
    {
        return $this->idHotel;
    }

    public function setIdHotel(?Hotel $idHotel): static
    {
        $this->idHotel = $idHotel;

        return $this;
    }

    public function getIdRoom(): ?Room
    {
        return $this->idRoom;
    }

    public function setIdRoom(Room $idRoom): static
    {
        $this->idRoom = $idRoom;

        return $this;
    }

    public function getAcceptanceThreshold(): ?int
    {
        return $this->acceptanceThreshold;
    }

    public function setAcceptanceThreshold(?int $acceptanceThreshold): static
    {
        $this->acceptanceThreshold = $acceptanceThreshold;

        return $this;
    }

    public function getRefusalThreshold(): ?int
    {
        return $this->refusalThreshold;
    }

    public function setRefusalThreshold(?int $refusalThreshold): static
    {
        $this->refusalThreshold = $refusalThreshold;

        return $this;
    }

    public function getAvailableFrom(): ?\DateTimeInterface
    {
        return $this->availableFrom;
    }

    public function setAvailableFrom(\DateTimeInterface $availableFrom): static
    {
        $this->availableFrom = $availableFrom;

        return $this;
    }

    public function getAvailableUntil(): ?\DateTimeInterface
    {
        return $this->availableUntil;
    }

    public function setAvailableUntil(\DateTimeInterface $availableUntil): static
    {
        $this->availableUntil = $availableUntil;

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

    public function getBooking(): ?Booking
    {
        return $this->booking;
    }

    public function setBooking(Booking $booking): static
    {
        // set the owning side of the relation if necessary
        if ($booking->getIdOffer() !== $this) {
            $booking->setIdOffer($this);
        }

        $this->booking = $booking;

        return $this;
    }
}
