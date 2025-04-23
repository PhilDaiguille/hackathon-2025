<?php

namespace App\Entity;

use App\Repository\PredefinedExtrasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PredefinedExtrasRepository::class)]
class PredefinedExtras
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Extras>
     */
    #[ORM\OneToMany(targetEntity: Extras::class, mappedBy: 'idPredefinedExtras')]
    private Collection $extras;

    #[ORM\Column(length: 2048)]
    private ?string $image = null;

    /**
     * @var Collection<int, Experiences>
     */
    #[ORM\OneToMany(targetEntity: Experiences::class, mappedBy: 'idPredefinedExtra')]
    private Collection $experiences;

    public function __construct()
    {
        $this->extras = new ArrayCollection();
        $this->experiences = new ArrayCollection();
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

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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

    /**
     * @return Collection<int, Extras>
     */
    public function getExtras(): Collection
    {
        return $this->extras;
    }

    public function addExtra(Extras $extra): static
    {
        if (!$this->extras->contains($extra)) {
            $this->extras->add($extra);
            $extra->setIdPredefinedExtras($this);
        }

        return $this;
    }

    public function removeExtra(Extras $extra): static
    {
        if ($this->extras->removeElement($extra)) {
            // set the owning side to null (unless already changed)
            if ($extra->getIdPredefinedExtras() === $this) {
                $extra->setIdPredefinedExtras(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Experiences>
     */
    public function getExperiences(): Collection
    {
        return $this->experiences;
    }

    public function addExperience(Experiences $experience): static
    {
        if (!$this->experiences->contains($experience)) {
            $this->experiences->add($experience);
            $experience->setIdPredefinedExtra($this);
        }

        return $this;
    }

    public function removeExperience(Experiences $experience): static
    {
        if ($this->experiences->removeElement($experience)) {
            // set the owning side to null (unless already changed)
            if ($experience->getIdPredefinedExtra() === $this) {
                $experience->setIdPredefinedExtra(null);
            }
        }

        return $this;
    }
}
