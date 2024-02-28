<?php

namespace App\Entity;

use App\Repository\SaisonDefiniRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SaisonDefiniRepository::class)]
class SaisonDefini
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $NomSaisons = null;

    #[ORM\OneToMany(targetEntity: Saisons::class, mappedBy: 'SD')]
    private Collection $saisons;

    public function __construct()
    {
        $this->saisons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSaisons(): ?string
    {
        return $this->NomSaisons;
    }

    public function setNomSaisons(?string $NomSaisons): static
    {
        $this->NomSaisons = $NomSaisons;

        return $this;
    }

    /**
     * @return Collection<int, Saisons>
     */
    public function getSaisons(): Collection
    {
        return $this->saisons;
    }

    public function addSaison(Saisons $saison): static
    {
        if (!$this->saisons->contains($saison)) {
            $this->saisons->add($saison);
            $saison->setSD($this);
        }

        return $this;
    }

    public function removeSaison(Saisons $saison): static
    {
        if ($this->saisons->removeElement($saison)) {
            // set the owning side to null (unless already changed)
            if ($saison->getSD() === $this) {
                $saison->setSD(null);
            }
        }

        return $this;
    }
}
