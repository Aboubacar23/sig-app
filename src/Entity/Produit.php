<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code_produit;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $libelle;

    #[ORM\ManyToOne(targetEntity: Fournisseur::class)]
    private $fournisseur;

    #[ORM\Column(type: 'float', nullable: true)]
    private $prix_achat;

    #[ORM\Column(type: 'float', nullable: true)]
    private $prix_vente;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $key_produit;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image;

    #[ORM\ManyToOne(targetEntity: Entrepot::class)]
    public $entrepot;

    #[ORM\Column(type: 'float', nullable: true)]
    private $stock_initial;

    #[ORM\Column(type: 'float', nullable: true)]
    private $quantite;

    #[ORM\Column(type: 'float', nullable: true)]
    private $poids;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $volume;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $couleur;

    #[ORM\Column(type: 'string',length: 255, nullable: true)]
    private $etat;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $reference;

    #[ORM\Column(type: 'text', nullable: true)]
    private $desciption;

    #[ORM\Column(type: 'float', nullable: true)]
    private $taux;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeProduit(): ?string
    {
        return $this->code_produit;
    }

    public function setCodeProduit(?string $code_produit): self
    {
        $this->code_produit = $code_produit;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function getPrixAchat(): ?float
    {
        return $this->prix_achat;
    }

    public function setPrixAchat(?float $prix_achat): self
    {
        $this->prix_achat = $prix_achat;

        return $this;
    }

    public function getPrixVente(): ?float
    {
        return $this->prix_vente;
    }

    public function setPrixVente(?float $prix_vente): self
    {
        $this->prix_vente = $prix_vente;

        return $this;
    }

    public function getKeyProduit(): ?string
    {
        return $this->key_produit;
    }

    public function setKeyProduit(?string $key_produit): self
    {
        $this->key_produit = $key_produit;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getEntrepot(): ?Entrepot
    {
        return $this->entrepot;
    }

    public function setEntrepot(?Entrepot $entrepot): self
    {
        $this->entrepot = $entrepot;

        return $this;
    }

    public function getStockInitial(): ?float
    {
        return $this->stock_initial;
    }

    public function setStockInitial(?float $stock_initial): self
    {
        $this->stock_initial = $stock_initial;

        return $this;
    }

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(?float $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPoids(): ?float
    {
        return $this->poids;
    }

    public function setPoids(?float $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getVolume(): ?string
    {
        return $this->volume;
    }

    public function setVolume(?string $volume): self
    {
        $this->volume = $volume;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(?string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDesciption(): ?string
    {
        return $this->desciption;
    }

    public function setDesciption(?string $desciption): self
    {
        $this->desciption = $desciption;

        return $this;
    }

    public function __toString(){
        return $this->getCodeProduit();
    }

    public function getTaux(): ?float
    {
        return $this->taux;
    }

    public function setTaux(?float $taux): self
    {
        $this->taux = $taux;

        return $this;
    }

}
