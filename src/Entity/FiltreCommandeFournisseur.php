<?php

namespace App\Entity;
	

class FiltreCommandeFournisseur {

    /** 
    *   @var string|null
    */
    private $fournisseur; 

	/**
	 * @var date|null
	*/
	private $periode_min;

	/**
	 * @var date|null
	*/
	private $periode_max;

   /**
    * @return date|null  
    */
   public function getPeriodeMin(): ?\DateTimeInterface
   {
       return $this->periode_min;
   }

    /**
    * @param date|null $periode_min
    * @return FiltreCommandeFournisseur 
    */
   public function setPeriodeMin(?\DateTimeInterface $periode_min): FiltreCommandeFournisseur
   {
       $this->periode_min = $periode_min;

       return $this;
   }


   /**
    * @return date|null  
    */
   public function getPeriodeMax(): ?\DateTimeInterface
   {
       return $this->periode_max;
   }

    /**
    * @param date|null $periode_max
    * @return FiltreCommandeFournisseur 
    */
   public function setPeriodeMax(?\DateTimeInterface $periode_max): FiltreCommandeFournisseur
   {
       $this->periode_max = $periode_max;

       return $this;
   }

   /**
    * @return string|null  
    */
    public function getFournisseur(): ?Fournisseur
   {
       return $this->fournisseur;
   }

    /**
    * @param string|null $fournisseur
    * @return FiltreCommandeFournisseur 
    */
   public function setFournisseur(?Fournisseur $fournisseur): FiltreCommandeFournisseur
   {
      $this->fournisseur = $fournisseur;

      return $this;
   }


}

 ?>