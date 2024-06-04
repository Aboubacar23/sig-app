<?php

namespace App\Controller;

use App\Entity\FactureClient;
use App\Entity\Versement;
use App\Entity\CommandeClient;
use App\Form\FactureClientType;
use App\Form\FactureClientModifType;
use App\Form\VersementModifType;
use App\Repository\FactureClientRepository;
use App\Repository\LCommandeClientRepository;
use App\Repository\LivraisonRepository;
use App\Repository\VersementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Proxies\__CG__\App\Entity\CommandeClient as EntityCommandeClient;

#[Route('/facture/client')]
class FactureClientController extends AbstractController
{
    #[Route('/', name: 'app_facture_client_index', methods: ['GET'])]
    public function index(FactureClientRepository $factureClientRepository, LCommandeClientRepository $lCommandeClientRepository): Response
    {
        return $this->render('facture_client/index.html.twig', [
            'facture_clients' => $factureClientRepository->findBy([], ['id'=> 'desc']),
            'lcommandes' => $lCommandeClientRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_facture_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FactureClientRepository $factureClientRepository,CommandeClient $commandeClient): Response
    { 
        $factureClient = new FactureClient();
        $form = $this->createForm(FactureClientType::class, $factureClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           // dd($factureClient->getAvance());
            $factureClient->setSomme($factureClient->getAvance());
            $commandeClient->setFlag(1);
            $factureClient->setCommande($commandeClient);
            $factureClientRepository->add($factureClient);
            return $this->redirectToRoute('app_facture_client_index', [], Response::HTTP_SEE_OTHER);
        } 

        $commandeAll = $factureClientRepository->findAll();
        $dernier = end($commandeAll);

        return $this->renderForm('facture_client/new.html.twig', [
            'facture_client' => $factureClient,
            'form' => $form,
            'dernier' => $dernier,
            'commande' => $commandeClient
        ]);
    }

    #[Route('/{id}', name: 'app_facture_client_show', methods: ['GET'])]
    public function show(FactureClient $factureClient, LCommandeClientRepository $lCommandeClientRepository): Response
    {
        return $this->render('facture_client/show.html.twig', [
            'facture_client' => $factureClient,
            'lcommande' => $lCommandeClientRepository->findAll()
        ]);
    }

    #[Route('/{id}/edit', name: 'app_facture_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FactureClient $factureClient, FactureClientRepository $factureClientRepository): Response
    {
        
        $form = $this->createForm(FactureClientModifType::class, $factureClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $factureClientRepository->add($factureClient);
            return $this->redirectToRoute('app_facture_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('facture_client/edit.html.twig', [
            'facture_client' => $factureClient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_facture_client_delete', methods: ['POST'])]
    public function delete(Request $request, FactureClient $factureClient, FactureClientRepository $factureClientRepository, LivraisonRepository $livraisonRepository, VersementRepository $versementRepository): Response
    {
        $versements = $versementRepository->findAll();
        $livraisons = $livraisonRepository->findAll();

        $var_l = 0;
        $var_v = 0;
        $tables = [];

        for($i = 0; $i < count($versements); $i++){
            if($versements[$i]->getFacture() != null){
                array_push($tables, $versements[$i]);
            }
        }
        for($i = 0; $i < count($tables); $i++){
            if($tables[$i]->getFacture()->getId() == $factureClient->getId()){
                $var_v = 1;
            }
        }

        for($i = 0; $i < count($livraisons); $i++){
            if($livraisons[$i]->getFacture()->getId() == $factureClient->getId()){
                $var_l = 1;
            }
        }

        if($var_l == 1)
        {
            $this->addFlash('error', "Désole vous ne pouvez pas supprimer cette facture car elle a été livrer ! Supprimer d'abord la livraison de la facture: ".$factureClient->getNumeroFacture());
            return $this->redirectToRoute('app_facture_client_show', [
                'id' => $factureClient->getId()
            ], Response::HTTP_SEE_OTHER);
        }
        elseif($var_v == 1)
        {
            $this->addFlash('error', "Désole vous ne pouvez pas supprimer cette facture car elle a des versements ! Supprimer d'abord les versements de la facture: ".$factureClient->getNumeroFacture());
            return $this->redirectToRoute('app_facture_client_show', [
                'id' => $factureClient->getId()
            ], Response::HTTP_SEE_OTHER);
        }
        else
        {
            if ($this->isCsrfTokenValid('delete'.$factureClient->getId(), $request->request->get('_token'))) {
                $factureClientRepository->remove($factureClient);
            }
            return $this->redirectToRoute('app_facture_client_index', [], Response::HTTP_SEE_OTHER);
        }

    }

    #[Route('/{id}/paiement/facture/client', name: 'app_facture_client_paiement', methods: ['GET'])]
    public function etatPaiement(FactureClient $factureClient, EntityManagerInterface $entityManager, LCommandeClientRepository $lCommandeClientRepository): Response
    {
        if($factureClient->getPaiement() == true){
            $factureClient->setPaiement(0);
        }else{
            $factureClient->setPaiement(1);
        }
        $entityManager->flush();
        return $this->render('facture_client/show.html.twig', [
            'facture_client' => $factureClient,
            'lcommande' => $lCommandeClientRepository->findAll()
        ]);
    }

    #[Route('/{id}/print/facture/client', name: 'app_print_facture')]
    public function printCommande(FactureClient $factureClient, LCommandeClientRepository $lCommandeClientRepository): Response
    {
        //$commande_clients = $commandeClientRepository->findAll();
        $lCommandes = $lCommandeClientRepository->findAll();

        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Times New Roman');
        $pdfOptions->setIsRemoteEnabled(true);
        $pdfOptions->setIsHtml5ParserEnabled(true);

        // On instancie Dompdf
        $dompdf = new Dompdf($pdfOptions);

        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);

        $dompdf->setHttpContext($context);

        $html = $this->renderView('facture_client/print.html.twig', [
            'facture_client' => $factureClient,
            'lcommandes' => $lCommandes
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $date = date('d-m-Y');
        $commandeClientNum = $factureClient->getNumeroFacture();
        // On génère un nom de fichier
        $fichier = 'Facture client - '.$commandeClientNum;

        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => false
        ]);

        exit();


    }


    #[Route('/{id}/paiement', name: 'facture_paiement', methods: ['GET', 'POST'])]
    public function paiement(Request $request, FactureClient $factureClient, EntityManagerInterface $entityManager, LCommandeClientRepository $lCommandeClientRepository): Response
    {
          $lc = $lCommandeClientRepository->findAll();

          $montantTotalTTC = 0; 
          $montantHT = 0; 
          $montantTTC = 0; 
          $montantTVA = 0; 
          $montantNet = 0; 
          $reste = 0; 

          for ($i=0; $i < count($lc); $i++) { 
            if ($lc[$i]->getNumCommande() == $factureClient->getCommande()) {
              $montantHT = $lc[$i]->getQuantite() * $lc[$i]->getProduit()->getPrixVente();
              $montantTVA = $montantHT * ($lc[$i]->getTva()/100);
              $montantTTC = $montantHT + $montantTVA - $lc[$i]->getRemise();


              $montantTotalTTC = $montantTotalTTC + $montantTTC ;
              $montantNet = $montantTotalTTC - $factureClient->getRemise();
              $reste = $montantNet - $factureClient->getSomme();
            }
          }

        $client = $factureClient->getCommande()->getClient();
        $versement = new Versement();
        $form = $this->createForm(VersementModifType::class, $versement);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($versement->getMontant() > $reste){

                $this->addFlash('error','Le montant saisi est supérieur au montant reste à paié');
                return $this->redirectToRoute('facture_paiement', [
                    'id' => $factureClient->getId(),    
                    'versement' => $versement,
                    'form' => $form,
                     "factureClient" => $factureClient,
                     'reste' => $reste,
                ]);
            }
            else{

                $newSom = $factureClient->getSomme() + $versement->getMontant();
                if($newSom >= $montantNet){
                    $factureClient->setPaiement(1);
                }
                $versement->setFacture($factureClient);
                $versement->setClient($client);
                $factureClient->setSomme($newSom);

                $entityManager->persist($versement);

                $entityManager->flush();
                return $this->redirectToRoute('app_facture_client_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('versement/facture_form.html.twig', [
            'versement' => $versement,
            'form' => $form,
             "factureClient" => $factureClient,
             'reste' => $reste,

        ]);
    }
}
