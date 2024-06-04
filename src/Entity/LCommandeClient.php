<?php

namespace App\Entity;

use App\Repository\LCommandeClientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LCommandeClientRepository::class)]
class LCommandeClient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Produit::class)]
    private $produit;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $quantite;

    #[ORM\Column(type: 'float', nullable: true)]
    private $tva;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $lig;

    #[ORM\ManyToOne(targetEntity: CommandeClient::class, cascade: ['persist'])]
    private $numCommande;

    #[ORM\Column(type: 'float', nullable: true)]
    private $remise;

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

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(?int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(?float $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getLig(): ?string
    {
        return $this->lig;
    }

    public function setLig(?string $lig): self
    {
        $this->lig = $lig;

        return $this;
    }

    public function getNumCommande(): ?CommandeClient
    {
        return $this->numCommande;
    }

    public function setNumCommande(?CommandeClient $numCommande): self
    {
        $this->numCommande = $numCommande;

        return $this;
    }

    public function getRemise(): ?float
    {
        return $this->remise;
    }

    public function setRemise(?float $remise): self
    {
        $this->remise = $remise;

        return $this;
    }
}
