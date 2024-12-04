<?php

namespace App\Entity;
use App\Repository\ProduitRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ORM\Table(name: '`produit`')]
class Produit {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;
    #[ORM\Column(length: 45, unique: true)]
    private string $nom;
    #[ORM\Column(type: Types::TEXT)]
    private string $description;
    #[ORM\Column]
    private int $prix;
    #[ORM\Column(length: 45)]
    private string $categorie;
    #[ORM\Column]
    private DateTime $creation;


    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(?int $id): void
    {
        $this->id = $id;
    }
    public function getNom(): ?string
    {
        return $this->nom;
    }
    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
    public function getPrix(): ?int
    {
        return $this->prix;
    }
    public function setPrix(?int $prix): void
    {
        $this->prix = $prix;
    }
    public function getCategorie(): ?string
    {
        return $this->categorie;
    }
    public function setCategorie(?string $categorie): void
    {
        $this->categorie = $categorie;
    }
    public function setCreation(?DateTime $creation): void
    {
        $this->creation = $creation;
    }
    public function getCreation(): ?DateTime
    {
        return $this->creation;
    }
}