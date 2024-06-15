<?php

namespace App\Entity;

use App\Repository\DepenseCamionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepenseCamionRepository::class)]
class DepenseCamion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'depenseCamions')]
    private ?Camion $camion = null;

    #[ORM\Column(length: 255)]
    private ?string $banque = null;

    #[ORM\Column(nullable: true)]
    private ?float $montant = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_depense = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mode_paiement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numero_cheque = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ordre_de = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCamion(): ?Camion
    {
        return $this->camion;
    }

    public function setCamion(?Camion $camion): static
    {
        $this->camion = $camion;

        return $this;
    }

    public function getBanque(): ?string
    {
        return $this->banque;
    }

    public function setBanque(string $banque): static
    {
        $this->banque = $banque;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(?float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateDepense(): ?\DateTimeInterface
    {
        return $this->date_depense;
    }

    public function setDateDepense(\DateTimeInterface $date_depense): static
    {
        $this->date_depense = $date_depense;

        return $this;
    }

    public function getModePaiement(): ?string
    {
        return $this->mode_paiement;
    }

    public function setModePaiement(?string $mode_paiement): static
    {
        $this->mode_paiement = $mode_paiement;

        return $this;
    }

    public function getNumeroCheque(): ?string
    {
        return $this->numero_cheque;
    }

    public function setNumeroCheque(?string $numero_cheque): static
    {
        $this->numero_cheque = $numero_cheque;

        return $this;
    }

    public function getOrdreDe(): ?string
    {
        return $this->ordre_de;
    }

    public function setOrdreDe(?string $ordre_de): static
    {
        $this->ordre_de = $ordre_de;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): static
    {
        $this->observation = $observation;

        return $this;
    }
}
