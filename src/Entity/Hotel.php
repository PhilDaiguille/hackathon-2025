<?php

namespace App\Entity;

use App\Repository\HotelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HotelRepository::class)]
class Hotel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $streetName = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $streetNumber = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $postalCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column]
    private ?float $rating = null;

    #[ORM\Column(length: 255)]
    private ?string $adminEmail = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Room>
     */
    #[ORM\OneToMany(targetEntity: Room::class, mappedBy: 'idHotel', orphanRemoval: true)]
    private Collection $rooms;

    /**
     * @var Collection<int, Offer>
     */
    #[ORM\OneToMany(targetEntity: Offer::class, mappedBy: 'idHotel')]
    private Collection $offers;

    /**
     * @var Collection<int, BlockedBooking>
     */
    #[ORM\OneToMany(targetEntity: BlockedBooking::class, mappedBy: 'idHotel', orphanRemoval: true)]
    private Collection $blockedBookings;

    /**
     * @var Collection<int, HotelImages>
     */
    #[ORM\OneToMany(targetEntity: HotelImages::class, mappedBy: 'idHotel')]
    private Collection $hotelImages;

    public function __construct()
    {
        $this->rooms = new ArrayCollection();
        $this->offers = new ArrayCollection();
        $this->blockedBookings = new ArrayCollection();
        $this->hotelImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStreetName(): ?string
    {
        return $this->streetName;
    }

    public function setStreetName(?string $streetName): static
    {
        $this->streetName = $streetName;

        return $this;
    }

    public function getStreetNumber(): ?string
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(?string $streetNumber): static
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(float $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getAdminEmail(): ?string
    {
        return $this->adminEmail;
    }

    public function setAdminEmail(string $adminEmail): static
    {
        $this->adminEmail = $adminEmail;

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

    /**
     * @return Collection<int, Room>
     */
    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function addRoom(Room $room): static
    {
        if (!$this->rooms->contains($room)) {
            $this->rooms->add($room);
            $room->setIdHotel($this);
        }

        return $this;
    }

    public function removeRoom(Room $room): static
    {
        if ($this->rooms->removeElement($room)) {
            // set the owning side to null (unless already changed)
            if ($room->getIdHotel() === $this) {
                $room->setIdHotel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Offer>
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    public function addOffer(Offer $offer): static
    {
        if (!$this->offers->contains($offer)) {
            $this->offers->add($offer);
            $offer->setIdHotel($this);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): static
    {
        if ($this->offers->removeElement($offer)) {
            // set the owning side to null (unless already changed)
            if ($offer->getIdHotel() === $this) {
                $offer->setIdHotel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BlockedBooking>
     */
    public function getBlockedBookings(): Collection
    {
        return $this->blockedBookings;
    }

    public function addBlockedBooking(BlockedBooking $blockedBooking): static
    {
        if (!$this->blockedBookings->contains($blockedBooking)) {
            $this->blockedBookings->add($blockedBooking);
            $blockedBooking->setIdHotel($this);
        }

        return $this;
    }

    public function removeBlockedBooking(BlockedBooking $blockedBooking): static
    {
        if ($this->blockedBookings->removeElement($blockedBooking)) {
            // set the owning side to null (unless already changed)
            if ($blockedBooking->getIdHotel() === $this) {
                $blockedBooking->setIdHotel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HotelImages>
     */
    public function getHotelImages(): Collection
    {
        return $this->hotelImages;
    }

    public function addHotelImage(HotelImages $hotelImage): static
    {
        if (!$this->hotelImages->contains($hotelImage)) {
            $this->hotelImages->add($hotelImage);
            $hotelImage->setIdHotel($this);
        }

        return $this;
    }

    public function removeHotelImage(HotelImages $hotelImage): static
    {
        if ($this->hotelImages->removeElement($hotelImage)) {
            // set the owning side to null (unless already changed)
            if ($hotelImage->getIdHotel() === $this) {
                $hotelImage->setIdHotel(null);
            }
        }

        return $this;
    }
}
