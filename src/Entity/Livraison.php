<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $num_livraison;

    #[ORM\ManyToOne(targetEntity: FactureClient::class)]
    private $facture;

    #[ORM\Column(type: 'date', nullable: true)]
    private $date_livraison;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $adresse;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumLivraison(): ?string
    {
        return $this->num_livraison;
    }

    public function setNumLivraison(?string $num_livraison): self
    {
        $this->num_livraison = $num_livraison;

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

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->date_livraison;
    }

    public function setDateLivraison(?\DateTimeInterface $date_livraison): self
    {
        $this->date_livraison = $date_livraison;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }
}
