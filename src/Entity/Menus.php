<?php

namespace App\Entity;

use App\Repository\MenusRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenusRepository::class)]
class Menus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;


    #[ORM\Column]
    private ?int $prix = null;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $formuleUne = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $formuleDeux = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descriptionFormuleDeux = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descriptionFormuleUne = null;



    public function getId(): ?int
    {
        return $this->id;
    }


    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }


    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }


    public function getFormuleUne(): ?string
    {
        return $this->formuleUne;
    }

    public function setFormuleUne(?string $formuleUne): self
    {
        $this->formuleUne = $formuleUne;

        return $this;
    }

    public function getFormuleDeux(): ?string
    {
        return $this->formuleDeux;
    }

    public function setFormuleDeux(?string $formuleDeux): self
    {
        $this->formuleDeux = $formuleDeux;

        return $this;
    }

    public function getDescriptionFormuleDeux(): ?string
    {
        return $this->descriptionFormuleDeux;
    }

    public function setDescriptionFormuleDeux(?string $descriptionFormuleDeux): self
    {
        $this->descriptionFormuleDeux = $descriptionFormuleDeux;

        return $this;
    }

    public function getDescriptionFormuleUne(): ?string
    {
        return $this->descriptionFormuleUne;
    }

    public function setDescriptionFormuleUne(?string $descriptionFormuleUne): self
    {
        $this->descriptionFormuleUne = $descriptionFormuleUne;

        return $this;
    }


}
