<?php

namespace App\Entity;

use App\Repository\FactureClientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FactureClientRepository::class)]
class FactureClient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $numero_facture;

    #[ORM\ManyToOne(targetEntity: CommandeClient::class)]
    private $commande;

    #[ORM\Column(type: 'date', nullable: true)]
    private $date_facturation;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $paiement;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $condition_paiement;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $mode_paiement;

    #[ORM\Column(type: 'float', nullable: true)]
    private $avance;

    #[ORM\Column(type: 'float', nullable: true)]
    private $remise;

    #[ORM\Column(type: 'float', nullable: true)]
    private $somme;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroFacture(): ?string
    {
        return $this->numero_facture;
    }

    public function setNumeroFacture(?string $numero_facture): self
    {
        $this->numero_facture = $numero_facture;

        return $this;
    }

    public function getCommande(): ?CommandeClient
    {
        return $this->commande;
    }

    public function setCommande(?CommandeClient $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getDateFacturation(): ?\DateTimeInterface
    {
        return $this->date_facturation;
    }

    public function setDateFacturation(?\DateTimeInterface $date_facturation): self
    {
        $this->date_facturation = $date_facturation;

        return $this;
    }

    public function getPaiement(): ?bool
    {
        return $this->paiement;
    }

    public function setPaiement(?bool $paiement): self
    {
        $this->paiement = $paiement;

        return $this;
    }

    public function getConditionPaiement(): ?string
    {
        return $this->condition_paiement;
    }

    public function setConditionPaiement(?string $condition_paiement): self
    {
        $this->condition_paiement = $condition_paiement;

        return $this;
    }

    public function getModePaiement(): ?string
    {
        return $this->mode_paiement;
    }

    public function setModePaiement(?string $mode_paiement): self
    {
        $this->mode_paiement = $mode_paiement;

        return $this;
    }

    public function __toString(){
        return $this->getNumeroFacture();
    }

    public function getAvance(): ?float
    {
        return $this->avance;
    }

    public function setAvance(?float $avance): self
    {
        $this->avance = $avance;

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

    public function getSomme(): ?float
    {
        return $this->somme;
    }

    public function setSomme(?float $somme): self
    {
        $this->somme = $somme;

        return $this;
    }
}
