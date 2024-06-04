<?php

namespace App\Entity;
	

class FiltreCommandeClient {

    /** 
    * @var string|null
    */
    public $client; 

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
    * @return FiltreCommandeClient 
    */
   public function setPeriodeMin(?\DateTimeInterface $periode_min): FiltreCommandeClient
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
    * @return FiltreCommandeClient 
    */
   public function setPeriodeMax(?\DateTimeInterface $periode_max): FiltreCommandeClient
   {
       $this->periode_max = $periode_max;

       return $this;
   }

   /**
    * @return string|null  
    */
    public function getClient(): ?Client
    {
       return $this->client;
    }

    /**
    * @param string|null $client
    * @return FiltreCommandeClient 
    */
   public function setClient(?Client $client): FiltreCommandeClient
   {
      $this->client = $client;

      return $this;
   }


}

 ?>