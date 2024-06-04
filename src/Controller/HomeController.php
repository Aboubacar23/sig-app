<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use App\Repository\PersonnelRepository;
use App\Repository\ClientRepository;
use App\Repository\FournisseurRepository;
use App\Repository\CommandeClientRepository;
use App\Repository\CommandeFournisseurRepository;
use App\Repository\FactureClientRepository;
use App\Repository\FactureFournisseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(
        PersonnelRepository $personnelRepository,
        ProduitRepository $produitRepository,
        ClientRepository $clientRepository,
        FournisseurRepository $fournisseurRepository,
        CommandeClientRepository $commandeClientRepository,
        CommandeFournisseurRepository $commandeFournisseurRepository,
        FactureClientRepository $factureClientRepository,
        FactureFournisseurRepository $factureFournisseurRepository,
    ): Response
    {   

        return $this->render('home/index.html.twig', [
            'personnels' => $personnelRepository->findAll(),
            'produits' => $produitRepository->findAll(),
            'clients' => $clientRepository->findAll(),
            'fournisseurs' => $fournisseurRepository->findAll(),
            'commandeCs' => $commandeClientRepository->findAll(),
            'commandeFs' => $commandeFournisseurRepository->findAll(),
            'factureCs' => $factureClientRepository->findAll(),
            'factureFs' => $factureFournisseurRepository->findAll()
        ]);
    } 
}
