<?php

namespace App\Entity;

use App\Repository\FactureFournisseurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FactureFournisseurRepository::class)]
class FactureFournisseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $numero_facture;

    #[ORM\ManyToOne(targetEntity: CommandeFournisseur::class)]
    private $commande;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $reference_paiement;

    #[ORM\Column(type: 'date', nullable: true)]
    private $date_limite_paiement;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $etat_paiement;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $condition_paiement;

    #[ORM\Column(type: 'date', nullable: true)]
    private $date_facturation;

    #[ORM\Column(type: 'text', nullable: true)]
    private $note;

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

    public function getCommande(): ?CommandeFournisseur
    {
        return $this->commande;
    }

    public function setCommande(?CommandeFournisseur $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getReferencePaiement(): ?string
    {
        return $this->reference_paiement;
    }

    public function setReferencePaiement(?string $reference_paiement): self
    {
        $this->reference_paiement = $reference_paiement;

        return $this;
    }

      public function getDateLimitePaiement(): ?\DateTimeInterface
    {
        return $this->date_limite_paiement;
    }

    public function setDateLimitePaiement(?\DateTimeInterface $date_limite_paiement): self
    {
        $this->date_limite_paiement = $date_limite_paiement;

        return $this;
    }

    public function getEtatPaiement(): ?bool
    {
        return $this->etat_paiement;
    }

    public function setEtatPaiement(?bool $etat_paiement): self
    {
        $this->etat_paiement = $etat_paiement;

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

    public function getDateFacturation(): ?\DateTimeInterface
    {
        return $this->date_facturation;
    }

    public function setDateFacturation(?\DateTimeInterface $date_facturation): self
    {
        $this->date_facturation = $date_facturation;

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
}
