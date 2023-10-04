<?php

namespace App\Entity;

use App\Form\CandidatureType;
use App\Repository\CandidatureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    //#[ORM\Column(length: 255)]
    #[ORM\OneToMany(mappedBy: 'candidature', targetEntity: Preference::class, orphanRemoval: true, cascade: ["persist"])]
    private Collection $preferences;

    #[ORM\ManyToOne(inversedBy: 'candidatures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'candidatures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Festival $festival = null;

    public function __construct()
    {
        $this->preferences = new ArrayCollection();
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

    /**
     * @return Collection<int, Candidature>
     */
    public function getPreferences(): Collection
    {
        return $this->preferences;
    }

    public function addPreference(Preference $preference): static
    {
        if (!$this->preferences->contains($preference)) {
            $this->preferences->add($preference);
            $preference->setCandidature($this);
        }

        return $this;
    }

    public function removePreference(Preference $preference): static
    {
        if ($this->preferences->removeElement($preference)) {
            // set the owning side to null (unless already changed)
            if ($preference->getUtilisateur() === $this) {
                $preference->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getFestival(): ?Festival
    {
        return $this->festival;
    }

    public function setFestival(?Festival $festival): static
    {
        $this->festival = $festival;

        return $this;
    }
}
