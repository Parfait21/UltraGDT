<?php

namespace App\Entity;

use App\Repository\ClientsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientsRepository::class)]
class Clients
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $NomClient = null;

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

}
