<?php

namespace App\Entity;

use App\Repository\RecetteCamionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecetteCamionRepository::class)]
class RecetteCamion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'recetteCamions')]
    private ?Camion $camion = null;

    #[ORM\Column]
    private ?float $montant_transport = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mode_paiement = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_recette = null;

    #[ORM\Column(length: 255)]
    private ?string $depart = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $banque = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numero_cheque = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $destination = null;

    #[ORM\Column(length: 255)]
    private ?string $type_tc = null;

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

    public function getMontantTransport(): ?float
    {
        return $this->montant_transport;
    }

    public function setMontantTransport(float $montant_transport): static
    {
        $this->montant_transport = $montant_transport;

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

    public function getDateRecette(): ?\DateTimeInterface
    {
        return $this->date_recette;
    }

    public function setDateRecette(\DateTimeInterface $date_recette): static
    {
        $this->date_recette = $date_recette;

        return $this;
    }

    public function getDepart(): ?string
    {
        return $this->depart;
    }

    public function setDepart(string $depart): static
    {
        $this->depart = $depart;

        return $this;
    }

    public function getBanque(): ?string
    {
        return $this->banque;
    }

    public function setBanque(?string $banque): static
    {
        $this->banque = $banque;

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

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(?string $destination): static
    {
        $this->destination = $destination;

        return $this;
    }

    public function getTypeTc(): ?string
    {
        return $this->type_tc;
    }

    public function setTypeTc(string $type_tc): static
    {
        $this->type_tc = $type_tc;

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
