<?php

namespace App\Entity;

use App\Repository\SaisonsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SaisonsRepository::class)]
class Saisons
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'dossierTeches')]
    #[Assert\NotBlank(message: "Veuillez selectionner un client.")]
    private ?Clients $clientId = null;

    #[ORM\OneToMany(targetEntity: DossierTech::class, mappedBy: 'saisonId')]
    private Collection $dossierTeches;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\NotBlank(message: "Veuillez saisir la saison.")]
    private ?string $NomSaison = null;

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

    public function getNomSaison(): ?string
    {
        return $this->NomSaison;
    }

    public function setNomSaison(?string $NomSaison): static
    {
        $this->NomSaison = $NomSaison;

        return $this;
    }
}
