<?php

namespace App\Entity;

use App\Repository\DossierTechRepository;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DossierTechRepository::class)]
class DossierTech
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez saisir la reference.")]
    private ?string $Reference = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateCreat = null;

    #[ORM\ManyToOne(inversedBy: 'dossierTeches')]
    #[Assert\NotBlank(message: "Veuillez selectionner la saison.")]
    private ?Saisons $saisonId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $File = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $TypeFicher = null;


    public function __construct()
    {
        $this->dateCreat = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateCreat(): ?\DateTimeInterface
    {
        return $this->dateCreat;
    }

    public function setDateCreat(\DateTimeInterface $dateCreat): static
    {
        $this->dateCreat = $dateCreat;

        return $this;
    }

    public function getSaisonId(): ?Saisons
    {
        return $this->saisonId;
    }

    public function setSaisonId(?Saisons $saisonId): static
    {
        $this->saisonId = $saisonId;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->File;
    }

    public function setFile(?string $File): static
    {
        $this->File = $File;

        return $this;
    }

    public function getTypeFicher(): ?string
    {
        return $this->TypeFicher;
    }

    public function setTypeFicher(?string $TypeFicher): static
    {
        $this->TypeFicher = $TypeFicher;

        return $this;
    }
}
