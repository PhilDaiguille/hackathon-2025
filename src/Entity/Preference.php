<?php

namespace App\Entity;

use App\Repository\PreferenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreferenceRepository::class)]
class Preference
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private array $categories = [];

    #[ORM\OneToOne(inversedBy: 'preference', cascade: ['persist', 'remove'])]
    private ?User $preferenceUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(array $categories): static
    {
        $this->categories = $categories;

        return $this;
    }

    public function getPreferenceUser(): ?User
    {
        return $this->preferenceUser;
    }

    public function setPreferenceUser(?User $preferenceUser): static
    {
        $this->preferenceUser = $preferenceUser;

        return $this;
    }
}
