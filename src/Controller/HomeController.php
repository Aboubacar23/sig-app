<?php

namespace App\Controller;

use App\Repository\CamionRepository;
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
        CamionRepository $camionRepository
    ): Response
    {   

        return $this->render('home/index.html.twig', [
            'personnels' => count($personnelRepository->findAll()),
            'produits' => count($produitRepository->findAll()),
            'clients' => count($clientRepository->findAll()),
            'fournisseurs' => count($fournisseurRepository->findAll()),
            'commandeCs' => count($commandeClientRepository->findAll()),
            'commandeFs' => count($commandeFournisseurRepository->findAll()),
            'factureCs' => count($factureClientRepository->findAll()),
            'factureFs' => count($factureFournisseurRepository->findAll()),
            'camions' => count($camionRepository->findAll())
        ]);
    } 
}
