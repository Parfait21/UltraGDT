<?php

namespace App\Entity;

use App\Repository\SaisonsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SaisonsRepository::class)]
class Saisons
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $NomSaison = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSaison(): ?string
    {
        return $this->NomSaison;
    }

    public function setNomSaison(string $NomSaison): static
    {
        $this->NomSaison = $NomSaison;

        return $this;
    }
}
