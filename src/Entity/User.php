<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[Vich\Uploadable]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]    
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

    #[Assert\Type('string')]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Votre prénom doit comporter au moins 2 caractères',
        maxMessage: 'Votre prénom ne peut pas contenir plus de 50 caractères',
    )]
    private ?string $first_name;

    #[Assert\Type('string')]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Votre nom doit comporter au moins 2 caractères',
        maxMessage: 'Votre nom ne peut pas contenir plus de 50 caractères',
    )]
    private ?string $last_name = null;

    #[Assert\Type('integer')]
    #[Assert\Regex(
        pattern: '/^[0-9]{1,10}$/',
        message: 'Le numéro de téléphone doit être composé de 10 chiffres.'
    )]
    private ?int $telephone = null;

    #[Assert\Type('string')]
    #[Assert\Length(
        min: 2,
        max: 1000,
        minMessage: 'Votre adresse doit comporter au moins 2 caractères',
        maxMessage: 'Votre adressse ne peut pas contenir plus de 50 caractères',
    )]
    private ?string $address = null;

    #[Assert\Type('string')]
    #[Assert\Length(
        min: 100,
        max: 10000,
        minMessage: 'Votre présenation doit comporter au moins 1000 caractères',
        maxMessage: 'Votre présentation ne peut pas contenir plus de 10000 caractères',
    )]
    private ?string $presentation = null;

    #[ORM\Column(type: "string", length: 555, nullable: true)]
    private ?string $employement_status = null;

    #[Assert\Type('integer')]
    #[Assert\Regex(
        pattern: '/^[0-9]{1,10}$/',
        message: 'Renseignez votre salaire au mois'
    )]
    private ?int $net_income = null;


    

    #[ORM\Column(type: "string", length: 555, nullable: true)]
    private ?string $guarantee = null;




    #[Assert\Type('string')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Le nom de votre agence doit comporter au moins 2 caractères',
        maxMessage: 'Le nom de votre agence ne peut pas contenir plus de 100 caractères',
    )]
    private ?string $nom_agence = null;

    #[Assert\Type('integer')]
    #[Assert\Regex(
        pattern: '/^[0-9]{4}$/',
        message: 'Le numéro de rue doit être composé de 1 ou chiffres.'
    )]
    private ?string $numero_rue = null;

    #[ORM\Column(type: "string", length: 555, nullable: true)]
    private ?string $nom_rue = null;

    #[Assert\Type('integer')]
    #[Assert\Regex(
        pattern: '/^[0-9]{5}$/',
        message: 'Le code postal doit être composé de 5 chiffres.'
    )]
    private ?string $code_postal = null;


    #[Assert\Type('string')]
    #[Assert\Length(
        min: 2,
        max: 60,
        minMessage: 'Le nom de votre ville doit comporter au moins 2 caractères',
        maxMessage: 'Le nom de votre ville ne peut pas contenir plus de 60 caractères',
    )]
    private ?string $ville = null;


    #[Assert\Type('integer')]
    #[Assert\Regex(
        pattern: '/^[0-9]{17}$/',
        message: 'Le numéro de carte professionnelle doit être composé de 17 chiffres.'
    )]
    private ?string $carte_professionnelle = null;



    #[Assert\Type('integer')]
    #[Assert\Regex(
        pattern: '/^[0-9]{9}$/',
        message: 'Le numéro siren doit être composé de 9 chiffres.'
    )]
    private ?string $siren = null;


    #[Assert\Type('integer')]
    #[Assert\Regex(
        pattern: '/^[0-9]{14}$/',
        message: 'Le numéro SIRET doit être composé de 14 chiffres.'
    )]
    private ?int $siret = null;

    #[ORM\Column(type: "string", length: 555, nullable: true)]
    private ?string $kbis = null;





    #[Vich\UploadableField(mapping: "profil_picture", fileNameProperty: "imageProfile", size: "imageSize")]
    private ?File $fichierImage;

    #[ORM\Column(type: "string", length: 555, nullable: true)]
    private $profile_picture; # stock dans la bdd 


    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;


    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?\DateTimeImmutable $updatedAt = null;


    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $fichierImage
     */
    public function setfichierImage(?File $fichierImage = null): void
    {
        $this->fichierImage = $fichierImage;

        if (null !== $fichierImage) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getfichierImage(): ?File
    {
        return $this->fichierImage;
    }

    public function setprofilepicture(?string $profile_picture): void
    {
        $this->profile_picture = $profile_picture;
    }

    public function getprofilepicture(): ?string
    {
        return $this->profile_picture;
    }


    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }






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
