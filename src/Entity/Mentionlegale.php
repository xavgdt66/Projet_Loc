<?php

namespace App\Entity;

use App\Repository\MentionlegaleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MentionlegaleRepository::class)]
class Mentionlegale
{
    #[ORM\Id]
    #[ORM\GeneratedValue] 
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 9000)]
    private ?string $Mentionlegale = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMentionlegale(): ?string
    {
        return $this->Mentionlegale;
    }

    public function setMentionlegale(string $Mentionlegale): static
    {
        $this->Mentionlegale = $Mentionlegale;

        return $this;
    }
}
