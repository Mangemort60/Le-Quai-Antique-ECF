<?php

namespace App\Entity;

use App\Repository\HorairesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HorairesRepository::class)]
class Horaires
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $jour = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $ouvertureMidi = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fermetureMidi = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $ouvertureSoir = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fermetureSoir = null;

    #[ORM\Column]
    private ?bool $Ouvert = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJour(): ?string
    {
        return $this->jour;
    }

    public function setJour(string $jour): self
    {
        $this->jour = $jour;

        return $this;
    }


    public function getOuvertureMidi(): ?\DateTimeInterface
    {
        return $this->ouvertureMidi;
    }

    public function setOuvertureMidi(\DateTimeInterface $ouvertureMidi): self
    {
        $this->ouvertureMidi = $ouvertureMidi;

        return $this;
    }

    public function getFermetureMidi(): ?\DateTimeInterface
    {
        return $this->fermetureMidi;
    }

    public function setFermetureMidi(\DateTimeInterface $fermetureMidi): self
    {
        $this->fermetureMidi = $fermetureMidi;

        return $this;
    }

    public function getOuvertureSoir(): ?\DateTimeInterface
    {
        return $this->ouvertureSoir;
    }

    public function setOuvertureSoir(\DateTimeInterface $ouvertureSoir): self
    {
        $this->ouvertureSoir = $ouvertureSoir;

        return $this;
    }

    public function getFermetureSoir(): ?\DateTimeInterface
    {
        return $this->fermetureSoir;
    }

    public function setFermetureSoir(\DateTimeInterface $fermetureSoir): self
    {
        $this->fermetureSoir = $fermetureSoir;

        return $this;
    }

    public function isOuvert(): ?bool
    {
        return $this->Ouvert;
    }

    public function setOuvert(bool $Ouvert): self
    {
        $this->Ouvert = $Ouvert;

        return $this;
    }

}
