<?php

namespace toubeelib\praticien\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'structure')]
class Structure
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private string $id;

    #[ORM\Column(type: 'string', length: 48)]
    private string $nom;

    #[ORM\Column(type: 'text')]
    private string $adresse;

    #[ORM\Column(type: 'string', length: 128, nullable: true)]
    private ?string $ville;

    #[ORM\Column(type: 'string', length: 12, nullable: true)]
    private ?string $code_postal;

    #[ORM\Column(type: 'string', length: 24, nullable: true)]
    private ?string $telephone;

    public function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
    }

    // Getters and setters
    public function getId(): string
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getAdresse(): string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): void
    {
        $this->ville = $ville;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(?string $code_postal): void
    {
        $this->code_postal = $code_postal;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): void
    {
        $this->telephone = $telephone;
    }
}
