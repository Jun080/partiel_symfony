<?php

namespace App\Entity;

use App\Repository\ResultatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultatRepository::class)]
class Resultat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $position = null;

    #[ORM\Column]
    private ?int $nombre_vote = null;

    #[ORM\OneToOne(mappedBy: 'resultat', cascade: ['persist', 'remove'])]
    private ?Theme $theme = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getNombreVote(): ?int
    {
        return $this->nombre_vote;
    }

    public function setNombreVote(int $nombre_vote): static
    {
        $this->nombre_vote = $nombre_vote;

        return $this;
    }

    public function getTheme(): ?Theme
    {
        return $this->theme;
    }

    public function setTheme(Theme $theme): static
    {
        if ($theme->getResultat() !== $this) {
            $theme->setResultat($this);
        }

        $this->theme = $theme;

        return $this;
    }
}
