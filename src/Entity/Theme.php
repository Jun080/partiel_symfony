<?php

namespace App\Entity;

use App\Repository\ThemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThemeRepository::class)]
class Theme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $theme = null;

    #[ORM\Column]
    private ?int $nombrePlacesGagnantes = null;

    /**
     * @var Collection<int, Proposition>
     */
    #[ORM\OneToMany(targetEntity: Proposition::class, mappedBy: 'theme', cascade: ['persist'])]
    private Collection $proposition;

    #[ORM\OneToOne(inversedBy: 'theme', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?Resultat $resultat = null;

    public function __construct()
    {
        $this->proposition = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): static
    {
        $this->theme = $theme;

        return $this;
    }

    public function getNombrePlacesGagnantes(): ?int
    {
        return $this->nombrePlacesGagnantes;
    }

    public function setNombrePlacesGagnantes(int $nombrePlacesGagnantes): static
    {
        $this->nombrePlacesGagnantes = $nombrePlacesGagnantes;

        return $this;
    }

    /**
     * @return Collection<int, Proposition>
     */
    public function getProposition(): Collection
    {
        return $this->proposition;
    }

    public function addProposition(Proposition $proposition): static
    {
        if (!$this->proposition->contains($proposition)) {
            $this->proposition->add($proposition);
            $proposition->setTheme($this);
        }

        return $this;
    }

    public function removeProposition(Proposition $proposition): static
    {
        if ($this->proposition->removeElement($proposition)) {
            // set the owning side to null (unless already changed)
            if ($proposition->getTheme() === $this) {
                $proposition->setTheme(null);
            }
        }

        return $this;
    }

    public function getResultat(): ?Resultat
    {
        return $this->resultat;
    }

    public function setResultat(Resultat $resultat): static
    {
        $this->resultat = $resultat;

        return $this;
    }
}
