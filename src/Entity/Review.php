<?php
// src/Entity/Review.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


#[ORM\Entity(repositoryClass:"App\Repository\ReviewRepository")]
 
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;


    #[ORM\ManyToOne(targetEntity: "App\Entity\User", inversedBy: "reviews")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private $user;


    #[ORM\Column(type: "datetime")]
    private $startDate;

    #[ORM\Column(type: "datetime")]
    private $endDate;


    #[ORM\Column(type: "text", nullable: true)]
    private $comment;


    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private $nomAgence;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getNomAgence(): ?string
    {
        return $this->nomAgence;
    }

    public function setNomAgence(?string $nomAgence): self
    {
        $this->nomAgence = $nomAgence;

        return $this;
    }

    // Méthode de validation
    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, $payload): void
    {
        if ($this->endDate < $this->startDate) {
            $context->buildViolation('La date de fin doit être postérieure à la date de début.')
                ->atPath('endDate')
                ->addViolation();
        }
    }
}
