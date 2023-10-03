<?php

namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidatureRepository::class)]
class Candidature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $descCandidature = null;

    #[ORM\Column(length: 255)]
    private ?int $idFestival = null;

    //#[ORM\Column(length: 255)]
    //private ?Festival $benevole = null;

    //#[ORM\Column(length: 255)]
    //#[ORM\OneToMany(targetEntity: Poste::class)]
    //private ?string $preferences = null;

    public function __construct(
        private string $idFestivalA
    ) {
        $this->idFestival = $idFestivalA;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescCandidature(): ?string
    {
        return $this->descCandidature;
    }

    public function setDescCandidature(string $descCandidature): static
    {
        $this->descCandidature = $descCandidature;

        return $this;
    }

    public function getPreferences(): ?string
    {
        return $this->preferences;
    }

    public function setPreferences(string $preferences): static
    {
        $this->preferences = $preferences;

        return $this;
    }
}
