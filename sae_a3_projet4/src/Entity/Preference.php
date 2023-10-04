<?php

namespace App\Entity;

use App\Repository\PreferenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreferenceRepository::class)]
class Preference
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Candidature::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Candidature $candidature = null;

    #[ORM\ManyToOne(targetEntity: Poste::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Poste $poste = null;


    public function getCandidature(): Candidature
    {
        return $this->candidature;
    }

    public function setCandidature(Candidature $candidature): static
    {
        $this->candidature = $candidature;

        return $this;
    }

    #[ORM\Column]
    private ?int $nbPreference = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoste(): ?Poste
    {
        return $this->poste;
    }

    public function setPoste(Poste $poste): static
    {
        $this->poste = $poste;

        return $this;
    }

    public function getNbPreference(): ?int
    {
        return $this->nbPreference;
    }

    public function setNbPreference(int $nbPreference): static
    {
        $this->nbPreference = $nbPreference;

        return $this;
    }
}
