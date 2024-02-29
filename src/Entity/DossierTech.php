<?php

namespace App\Entity;

use App\Repository\DossierTechRepository;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DossierTechRepository::class)]
class DossierTech
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $NomDossier = null;

    #[ORM\Column(length: 255)]
    private ?string $Reference = null;

    #[ORM\Column(length: 50)]
    private ?string $Taille = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateCreat = null;

    #[ORM\ManyToOne(inversedBy: 'dossierTeches')]
    private ?Saisons $NomSaison = null;

    /**
     * @var File|null
     */
    private ?File $File = null;

    public function __construct()
    {
        $this->dateCreat = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDossier(): ?string
    {
        return $this->NomDossier;
    }

    public function setNomDossier(string $NomDossier): static
    {
        $this->NomDossier = $NomDossier;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->Reference;
    }

    public function setReference(string $Reference): static
    {
        $this->Reference = $Reference;

        return $this;
    }

    public function getTaille(): ?string
    {
        return $this->Taille;
    }

    public function setTaille(string $Taille): static
    {
        $this->Taille = $Taille;

        return $this;
    }

    public function getDateCreat(): ?\DateTimeInterface
    {
        return $this->dateCreat;
    }

    public function setDateCreat(\DateTimeInterface $dateCreat): static
    {
        $this->dateCreat = $dateCreat;

        return $this;
    }

    public function getNomSaison(): ?Saisons
    {
        return $this->NomSaison;
    }

    public function setNomSaison(?Saisons $NomSaison): static
    {
        $this->NomSaison = $NomSaison;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->File;
    }

    public function setFile(?string $File): self
    {
        $this->File = $File;

        return $this;
    }
}
