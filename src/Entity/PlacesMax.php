<?php

namespace App\Entity;

use App\Repository\PlacesMaxRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlacesMaxRepository::class)]
class PlacesMax
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nbrPlacesMax = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbrPlacesMax(): ?int
    {
        return $this->nbrPlacesMax;
    }

    public function setNbrPlacesMax(int $nbrPlacesMax): self
    {
        $this->nbrPlacesMax = $nbrPlacesMax;

        return $this;
    }
}
