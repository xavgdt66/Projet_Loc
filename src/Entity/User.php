<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    private ?string $first_name = null;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    private ?string $last_name = null;

    #[ORM\Column(type:"string", length:555, nullable:true)]
    private ?string $telephone = null;

    #[ORM\Column(type:"string", length:555, nullable:true)]
    private ?string $address = null;

    #[ORM\Column(type:"string", length:555, nullable:true)]
    private ?string $presentation = null;

    #[ORM\Column(type:"string", length:555, nullable:true)]
    private ?string $employement_status = null;

    #[ORM\Column(type:"string", length:555, nullable:true)]
    private ?string $net_income = null;

    #[ORM\Column(type:"string", length:555, nullable:true)]
    private ?string $guarantee = null;

    #[ORM\Column(type:"string", length:555, nullable:true)]
    private ?string $nom_agence = null;

    #[ORM\Column(type:"string", length:555, nullable:true)]
    private ?string $numero_rue = null;

    #[ORM\Column(type:"string", length:555, nullable:true)]
    private ?string $nom_rue = null;

    #[ORM\Column(type:"string", length:555, nullable:true)]
    private ?string $code_postal = null;

    #[ORM\Column(type:"string", length:555, nullable:true)]
    private ?string $ville = null;

    #[ORM\Column(type:"string", length:555, nullable:true)]
    private ?string $carte_professionnelle = null;

    #[ORM\Column(type:"string", length:555, nullable:true)]
    private ?string $siren = null;

    #[ORM\Column(type:"string", length:555, nullable:true)]
    private ?string $siret = null;

    #[ORM\Column(type:"string", length:555, nullable:true)]
    private ?string $kbis = null;

    #[ORM\Column(type:"string", length:555, nullable:true)]
    private $profile_picture;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }
   
    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): static
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getEmployementStatus(): ?string
    {
        return $this->employement_status;
    }

    public function setEmployementStatus(string $employement_status): static
    {
        $this->employement_status = $employement_status;

        return $this;
    }

    public function getNetIncome(): ?string
    {
        return $this->net_income;
    }

    public function setNetIncome(string $net_income): static
    {
        $this->net_income = $net_income;

        return $this;
    }

    public function getGuarantee(): ?string
    {
        return $this->guarantee;
    }

    public function setGuarantee(string $guarantee): static
    {
        $this->guarantee = $guarantee;

        return $this;
    }

    public function getNomAgence(): ?string
    {
        return $this->nom_agence;
    }

    public function setNomAgence(string $nom_agence): static
    {
        $this->nom_agence = $nom_agence;

        return $this;
    }

    public function getNumeroRue(): ?string
    {
        return $this->numero_rue;
    }

    public function setNumeroRue(string $numero_rue): static
    {
        $this->numero_rue = $numero_rue;

        return $this;
    }

    public function getNomRue(): ?string
    {
        return $this->nom_rue;
    }

    public function setNomRue(string $nom_rue): static
    {
        $this->nom_rue = $nom_rue;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): static
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCarteProfessionnelle(): ?string
    {
        return $this->carte_professionnelle;
    }

    public function setCarteProfessionnelle(string $carte_professionnelle): static
    {
        $this->carte_professionnelle = $carte_professionnelle;

        return $this;
    }

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(string $siren): static
    {
        $this->siren = $siren;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): static
    {
        $this->siret = $siret;

        return $this;
    }

    public function getKbis(): ?string
    {
        return $this->kbis;
    }

    public function setKbis(string $kbis): static
    {
        $this->kbis = $kbis;

        return $this;
    }

   

    public function setprofile_picture(string $profile_picture): static
    {
        $this->profile_picture = $profile_picture;

        return $this;
    }

    public function getprofile_picture(): ?string
    {
        return $this->profile_picture;
    }
}
