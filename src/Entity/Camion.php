<?php

namespace App\Entity;

use App\Repository\CamionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CamionRepository::class)]
class Camion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numero_camion = null;

    #[ORM\Column(length: 255)]
    private ?string $chauffeur = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column(length: 255)]
    private ?string $marque = null;

    #[ORM\OneToMany(mappedBy: 'camion', targetEntity: RecetteCamion::class)]
    private Collection $recetteCamions;

    #[ORM\OneToMany(mappedBy: 'camion', targetEntity: DepenseCamion::class)]
    private Collection $depenseCamions;

    public function __construct()
    {
        $this->recetteCamions = new ArrayCollection();
        $this->depenseCamions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCamion(): ?string
    {
        return $this->numero_camion;
    }

    public function setNumeroCamion(string $numero_camion): static
    {
        $this->numero_camion = $numero_camion;

        return $this;
    }

    public function getChauffeur(): ?string
    {
        return $this->chauffeur;
    }

    public function setChauffeur(string $chauffeur): static
    {
        $this->chauffeur = $chauffeur;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * @return Collection<int, RecetteCamion>
     */
    public function getRecetteCamions(): Collection
    {
        return $this->recetteCamions;
    }

    public function addRecetteCamion(RecetteCamion $recetteCamion): static
    {
        if (!$this->recetteCamions->contains($recetteCamion)) {
            $this->recetteCamions->add($recetteCamion);
            $recetteCamion->setCamion($this);
        }

        return $this;
    }

    public function removeRecetteCamion(RecetteCamion $recetteCamion): static
    {
        if ($this->recetteCamions->removeElement($recetteCamion)) {
            // set the owning side to null (unless already changed)
            if ($recetteCamion->getCamion() === $this) {
                $recetteCamion->setCamion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DepenseCamion>
     */
    public function getDepenseCamions(): Collection
    {
        return $this->depenseCamions;
    }

    public function addDepenseCamion(DepenseCamion $depenseCamion): static
    {
        if (!$this->depenseCamions->contains($depenseCamion)) {
            $this->depenseCamions->add($depenseCamion);
            $depenseCamion->setCamion($this);
        }

        return $this;
    }

    public function removeDepenseCamion(DepenseCamion $depenseCamion): static
    {
        if ($this->depenseCamions->removeElement($depenseCamion)) {
            // set the owning side to null (unless already changed)
            if ($depenseCamion->getCamion() === $this) {
                $depenseCamion->setCamion(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNumeroCamion();
    }
}
