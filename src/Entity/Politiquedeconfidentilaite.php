<?php

namespace App\Entity;

use App\Repository\PolitiquedeconfidentilaiteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PolitiquedeconfidentilaiteRepository::class)]
class Politiquedeconfidentilaite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column] 
    private ?int $id = null;

    #[ORM\Column(length: 9000)]
    private ?string $Pol = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPol(): ?string
    {
        return $this->Pol;
    }

    public function setPol(string $Pol): static
    {
        $this->Pol = $Pol;

        return $this;
    }
}
