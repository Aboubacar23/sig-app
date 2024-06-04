<?php

namespace App\Entity;

use App\Repository\CommandeClientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeClientRepository::class)]
class CommandeClient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code_commande;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $numero_reference;

    #[ORM\ManyToOne(targetEntity: Client::class)]
    private $client;

    #[ORM\Column(type: 'date', nullable: true)]
    private $date_commande;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $type_commande;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $etat;

    #[ORM\Column(type: 'text', nullable: true)]
    private $note;

    #[ORM\Column(type: 'date', nullable: true)]
    private $paiement_date;

    #[ORM\Column(type: 'date', nullable: true)]
    private $reception_date;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $flag;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeCommande(): ?string
    {
        return $this->code_commande;
    }

    public function setCodeCommande(?string $code_commande): self
    {
        $this->code_commande = $code_commande;

        return $this;
    }

    public function getNumeroReference(): ?string
    {
        return $this->numero_reference;
    }

    public function setNumeroReference(?string $numero_reference): self
    {
        $this->numero_reference = $numero_reference;

        return $this;
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

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(?\DateTimeInterface $date_commande): self
    {
        $this->date_commande = $date_commande;

        return $this;
    }

    public function getTypeCommande(): ?string
    {
        return $this->type_commande;
    }

    public function setTypeCommande(?string $type_commande): self
    {
        $this->type_commande = $type_commande;

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

    public function getPaiementDate(): ?\DateTimeInterface
    {
        return $this->paiement_date;
    }

    public function setPaiementDate(?\DateTimeInterface $paiement_date): self
    {
        $this->paiement_date = $paiement_date;

        return $this;
    }

    public function getReceptionDate(): ?\DateTimeInterface
    {
        return $this->reception_date;
    }

    public function setReceptionDate(?\DateTimeInterface $reception_date): self
    {
        $this->reception_date = $reception_date;

        return $this;
    }

    public function __toString(){
        return $this->getCodeCommande();
    }

    public function isFlag(): ?bool
    {
        return $this->flag;
    }

    public function setFlag(?bool $flag): self
    {
        $this->flag = $flag;

        return $this;
    }

}
