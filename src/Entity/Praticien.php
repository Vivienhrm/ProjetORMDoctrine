<?php

namespace toubeelib\praticien\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use toubeelib\praticien\Repository\PraticienRepository;

#[ORM\Entity(repositoryClass: PraticienRepository::class)]
#[ORM\Table(name: 'praticien')]
class Praticien
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private string $id;

    #[ORM\Column(type: 'string', length: 48)]
    private string $nom;

    #[ORM\Column(type: 'string', length: 48)]
    private string $prenom;

    #[ORM\Column(type: 'string', length: 48)]
    private string $ville;

    #[ORM\Column(type: 'string', length: 128)]
    private string $email;

    #[ORM\Column(type: 'string', length: 24)]
    private string $telephone;

    #[ORM\ManyToOne(targetEntity: Specialite::class)]
    #[ORM\JoinColumn(name: 'specialite_id', referencedColumnName: 'id')]
    private Specialite $specialite;

    #[ORM\ManyToOne(targetEntity: Structure::class)]
    #[ORM\JoinColumn(name: 'structure_id', referencedColumnName: 'id', nullable: true)]
    private ?Structure $structure;

    #[ORM\Column(type: 'string', length: 12, nullable: true)]
    private ?string $rpps_id;

    #[ORM\Column(type: 'string', length: 1)]
    private string $organisation = '0';

    #[ORM\Column(type: 'string', length: 1)]
    private string $nouveau_patient = '1';

    #[ORM\Column(type: 'string', length: 8, options: ['default' => 'Dr.'])]
    private string $titre = 'Dr.';

    #[ORM\ManyToMany(targetEntity: MotifVisite::class)]
    #[ORM\JoinTable(name: 'praticien2motif')]
    #[ORM\JoinColumn(name: 'praticien_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'motif_id', referencedColumnName: 'id')]
    private Collection $motifsVisite;

    #[ORM\ManyToMany(targetEntity: MoyenPaiement::class)]
    #[ORM\JoinTable(name: 'praticien2moyen')]
    #[ORM\JoinColumn(name: 'praticien_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'moyen_id', referencedColumnName: 'id')]
    private Collection $moyensPaiement;

    public function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
        $this->motifsVisite = new ArrayCollection();
        $this->moyensPaiement = new ArrayCollection();
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

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function getVille(): string
    {
        return $this->ville;
    }

    public function setVille(string $ville): void
    {
        $this->ville = $ville;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function getSpecialite(): Specialite
    {
        return $this->specialite;
    }

    public function setSpecialite(Specialite $specialite): void
    {
        $this->specialite = $specialite;
    }

    public function getStructure(): ?Structure
    {
        return $this->structure;
    }

    public function setStructure(?Structure $structure): void
    {
        $this->structure = $structure;
    }

    public function getRppsId(): ?string
    {
        return $this->rpps_id;
    }

    public function setRppsId(?string $rpps_id): void
    {
        $this->rpps_id = $rpps_id;
    }

    public function isOrganisation(): bool
    {
        return $this->organisation;
    }

    public function setOrganisation(bool $organisation): void
    {
        $this->organisation = $organisation;
    }

    public function isNouveauPatient(): bool
    {
        return $this->nouveau_patient;
    }

    public function setNouveauPatient(bool $nouveau_patient): void
    {
        $this->nouveau_patient = $nouveau_patient;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }

    public function getMotifsVisite(): Collection
    {
        return $this->motifsVisite;
    }

    public function addMotifVisite(MotifVisite $motifVisite): void
    {
        if (!$this->motifsVisite->contains($motifVisite)) {
            $this->motifsVisite->add($motifVisite);
        }
    }

    public function removeMotifVisite(MotifVisite $motifVisite): void
    {
        $this->motifsVisite->removeElement($motifVisite);
    }

    public function getMoyensPaiement(): Collection
    {
        return $this->moyensPaiement;
    }

    public function addMoyenPaiement(MoyenPaiement $moyenPaiement): void
    {
        if (!$this->moyensPaiement->contains($moyenPaiement)) {
            $this->moyensPaiement->add($moyenPaiement);
        }
    }

    public function removeMoyenPaiement(MoyenPaiement $moyenPaiement): void
    {
        $this->moyensPaiement->removeElement($moyenPaiement);
    }
}
