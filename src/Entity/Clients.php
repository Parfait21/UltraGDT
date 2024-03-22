<?php

namespace App\Entity;

use App\Repository\ClientsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientsRepository::class)]
class Clients
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "Veuillez saisir le nom du client.")]
    private ?string $NomClient = null;

    #[ORM\OneToMany(targetEntity: Saisons::class, mappedBy: 'clientId', cascade: ['remove'])] // Ajout de cascade={"remove"}
    private Collection $saisons;

    public function __construct()
    {
        $this->saisons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomClient(): ?string
    {
        return $this->NomClient;
    }

    public function setNomClient(string $NomClient): static
    {
        $this->NomClient = $NomClient;

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
            $saison->setClientId($this);
        }

        return $this;
    }

    public function removeSaison(Saisons $saison): static
    {
        if ($this->saisons->removeElement($saison)) {
            // set the owning side to null (unless already changed)
            if ($saison->getClientId() === $this) {
                $saison->setClientId(null);
            }
        }

        return $this;
    }

}
