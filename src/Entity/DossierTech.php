<?php

namespace App\Entity;

use App\Repository\DossierTechRepository;
use Doctrine\DBAL\Types\Types;
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
    private ?\DateTimeInterface $dateOkPord = null;

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

    public function getDateOkPord(): ?\DateTimeInterface
    {
        return $this->dateOkPord;
    }

    public function setDateOkPord(\DateTimeInterface $dateOkPord): static
    {
        $this->dateOkPord = $dateOkPord;

        return $this;
    }
}