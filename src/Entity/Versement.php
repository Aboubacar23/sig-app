<?php

namespace App\Entity;

use App\Repository\VersementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VersementRepository::class)]
class Versement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Client::class)]
    private $client;

    #[ORM\Column(type: 'float', nullable: true)]
    private $montant;

    #[ORM\Column(type: 'date', nullable: true)]
    private $date_versement;

    #[ORM\ManyToOne(targetEntity: Banque::class)]
    private $banque;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $avance;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $type_reglement;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $delegue;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $emetteur_cheque;

    #[ORM\ManyToOne(targetEntity: FactureClient::class)]
    private $facture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(?float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateVersement(): ?\DateTimeInterface
    {
        return $this->date_versement;
    }

    public function setDateVersement(?\DateTimeInterface $date_versement): self
    {
        $this->date_versement = $date_versement;

        return $this;
    }

    public function getBanque(): ?Banque
    {
        return $this->banque;
    }

    public function setBanque(?Banque $banque): self
    {
        $this->banque = $banque;

        return $this;
    }

    public function isAvance(): ?bool
    {
        return $this->avance;
    }

    public function setAvance(?bool $avance): self
    {
        $this->avance = $avance;

        return $this;
    }

    public function getTypeReglement(): ?string
    {
        return $this->type_reglement;
    }

    public function setTypeReglement(?string $type_reglement): self
    {
        $this->type_reglement = $type_reglement;

        return $this;
    }

    public function getDelegue(): ?string
    {
        return $this->delegue;
    }

    public function setDelegue(?string $delegue): self
    {
        $this->delegue = $delegue;

        return $this;
    }

    public function getEmetteurCheque(): ?string
    {
        return $this->emetteur_cheque;
    }

    public function setEmetteurCheque(?string $emetteur_cheque): self
    {
        $this->emetteur_cheque = $emetteur_cheque;

        return $this;
    }

    public function getFacture(): ?FactureClient
    {
        return $this->facture;
    }

    public function setFacture(?FactureClient $facture): self
    {
        $this->facture = $facture;

        return $this;
    }
}
