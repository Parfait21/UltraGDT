<?php

namespace App\Entity;

use App\Repository\SaisonsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SaisonsRepository::class)]
class Saisons
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'saisons')]
    private ?Clients $clientId = null;

    #[ORM\ManyToOne(inversedBy: 'saisons')]
    private ?SaisonDefini $SD = null;

    #[ORM\OneToMany(targetEntity: DossierTech::class, mappedBy: 'saisonId')]
    private Collection $dossierTeches;

    public function __construct()
    {
        $this->dossierTeches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientId(): ?Clients
    {
        return $this->clientId;
    }

    public function setClientId(?Clients $clientId): static
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * @return Collection<int, DossierTech>
     */
    public function getDossierTeches(): Collection
    {
        return $this->dossierTeches;
    }

    public function addDossierTech(DossierTech $dossierTech): static
    {
        if (!$this->dossierTeches->contains($dossierTech)) {
            $this->dossierTeches->add($dossierTech);
            $dossierTech->setSaisonId($this);
        }

        return $this;
    }

    public function removeDossierTech(DossierTech $dossierTech): static
    {
        if ($this->dossierTeches->removeElement($dossierTech)) {
            // set the owning side to null (unless already changed)
            if ($dossierTech->getSaisonId() === $this) {
                $dossierTech->setSaisonId(null);
            }
        }

        return $this;
    }

    public function getSD(): ?SaisonDefini
    {
        return $this->SD;
    }

    public function setSD(?SaisonDefini $SD): static
    {
        $this->SD = $SD;

        return $this;
    }
}
