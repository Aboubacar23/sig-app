<?php

namespace App\Entity;

use App\Repository\CommandeFournisseurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeFournisseurRepository::class)]
class CommandeFournisseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $numero_commande;

    #[ORM\ManyToOne(targetEntity: Fournisseur::class)]
    private $fournisseur;

    #[ORM\Column(type: 'date', nullable: true)]
    private $date_commande;

    #[ORM\Column(type: 'date', nullable: true)]
    private $paiement_date;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $paiement_mode;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $expedition_mode;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $etat;

    #[ORM\Column(type: 'text', nullable: true)]
    private $note;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getNumeroCommande(): ?string
    {
        return $this->numero_commande;
    }

    public function setNumeroCommande(?string $numero_commande): self
    {
        $this->numero_commande = $numero_commande;

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

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(?\DateTimeInterface $date_commande): self
    {
        $this->date_commande = $date_commande;

        return $this;
    }

    public function getPaiementDate(): ?\DateTimeInterface
    {
        return $this->paiement_date;
    }

    public function setPaiementDate(?\DateTimeInterface $paiement_date): self
    {
        $this->paiement_date = $paiement_date;

        return $this;
    }

    public function getPaiementMode(): ?string
    {
        return $this->paiement_mode;
    }

    public function setPaiementMode(?string $paiement_mode): self
    {
        $this->paiement_mode = $paiement_mode;

        return $this;
    }

    public function getExpeditionMode(): ?string
    {
        return $this->expedition_mode;
    }

    public function setExpeditionMode(?string $expedition_mode): self
    {
        $this->expedition_mode = $expedition_mode;

        return $this;
    }

    public function getEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(?bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function __toString(){
        return $this->getNumeroCommande();
    }
}
