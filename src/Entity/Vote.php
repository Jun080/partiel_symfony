<?php

namespace App\Entity;

use App\Repository\VoteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoteRepository::class)]
class Vote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Bulletin>
     */
    #[ORM\OneToMany(targetEntity: Bulletin::class, mappedBy: 'vote')]
    private Collection $bulletin;

    /**
     * @var Collection<int, Electeurs>
     */
    #[ORM\OneToMany(targetEntity: Electeurs::class, mappedBy: 'vote')]
    private Collection $electeurs;

    public function __construct()
    {
        $this->bulletin = new ArrayCollection();
        $this->electeurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Bulletin>
     */
    public function getBulletin(): Collection
    {
        return $this->bulletin;
    }

    public function addBulletin(Bulletin $bulletin): static
    {
        if (!$this->bulletin->contains($bulletin)) {
            $this->bulletin->add($bulletin);
            $bulletin->setVote($this);
        }

        return $this;
    }

    public function removeBulletin(Bulletin $bulletin): static
    {
        if ($this->bulletin->removeElement($bulletin)) {
            // set the owning side to null (unless already changed)
            if ($bulletin->getVote() === $this) {
                $bulletin->setVote(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Electeurs>
     */
    public function getElecteurs(): Collection
    {
        return $this->electeurs;
    }

    public function addElecteur(Electeurs $electeur): static
    {
        if (!$this->electeurs->contains($electeur)) {
            $this->electeurs->add($electeur);
            $electeur->setVote($this);
        }

        return $this;
    }

    public function removeElecteur(Electeurs $electeur): static
    {
        if ($this->electeurs->removeElement($electeur)) {
            // set the owning side to null (unless already changed)
            if ($electeur->getVote() === $this) {
                $electeur->setVote(null);
            }
        }

        return $this;
    }
}
