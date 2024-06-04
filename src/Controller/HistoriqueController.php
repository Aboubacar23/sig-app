<?php

namespace App\Controller;

use App\Entity\FiltreCommandeFournisseur;
use App\Form\FiltreCommandeFournisseurType;
use App\Entity\FiltreCommandeClient;
use App\Form\FiltreCommandeClientType;
use App\Repository\CommandeFournisseurRepository;
use App\Repository\CommandeClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/historique')]
class HistoriqueController extends AbstractController
{
    #[Route('/liste/com/four', name: 'app_historique_commande_fournisseur')]
    public function commandeFournisseur(CommandeFournisseurRepository $commandeFournisseurRepository, Request $request): Response
    {
        $recherche =  new FiltreCommandeFournisseur();
        $form = $this->createForm(FiltreCommandeFournisseurType::class, $recherche);
        $form->handleRequest($request); 

        $commandes = $commandeFournisseurRepository->findAllFournisseur($recherche);

        return $this->render('historique/historique_commande_fournisseur.html.twig', [
            'commande_fournisseurs' => $commandes,
            'form' => $form->createView()
            
        ]);
    }

    #[Route('/all/client', name: 'app_historique_commande_client')]
    public function commandeClient(CommandeClientRepository $commandeClientRepository, Request $request): Response
    {
        $recherche =  new FiltreCommandeClient();
        $form = $this->createForm(FiltreCommandeClientType::class, $recherche);
        $form->handleRequest($request); 

        $commandes = $commandeClientRepository->findAllClient($recherche);
        
        return $this->render('historique/historique_commande_client.html.twig', [
            'commande_clients' => $commandes,
            'form' => $form->createView()
        ]);
    }

}
