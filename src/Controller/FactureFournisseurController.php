<?php

namespace App\Controller;

use App\Entity\FactureFournisseur;
use App\Form\FactureFournisseurType;
use App\Repository\FactureFournisseurRepository;
use App\Repository\LCommandeFournisseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

#[Route('/facture/fournisseur')]
class FactureFournisseurController extends AbstractController
{
    #[Route('/', name: 'app_facture_fournisseur_index', methods: ['GET'])]
    public function index(FactureFournisseurRepository $factureFournisseurRepository): Response
    {
        return $this->render('facture_fournisseur/index.html.twig', [
            'facture_fournisseurs' => $factureFournisseurRepository->findBy([], ['id' => 'desc']),
        ]);
    }

    #[Route('/new', name: 'app_facture_fournisseur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FactureFournisseurRepository $factureFournisseurRepository): Response
    {
        $factureFournisseur = new FactureFournisseur();
        $form = $this->createForm(FactureFournisseurType::class, $factureFournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $factureFournisseurRepository->add($factureFournisseur);
            return $this->redirectToRoute('app_facture_fournisseur_index', [], Response::HTTP_SEE_OTHER);
        }

        $factureAll = $factureFournisseurRepository->findAll();
        $dernier = end($factureAll);
        return $this->renderForm('facture_fournisseur/new.html.twig', [
            'facture_fournisseur' => $factureFournisseur,
            'form' => $form,
            'dernier' => $dernier
        ]);
    }

    #[Route('/{id}', name: 'app_facture_fournisseur_show', methods: ['GET'])]
    public function show(FactureFournisseur $factureFournisseur, LCommandeFournisseurRepository $lCommandeFournisseurRepository): Response
    {
        return $this->render('facture_fournisseur/show.html.twig', [
            'facture_fournisseur' => $factureFournisseur,
            'lcommande' => $lCommandeFournisseurRepository->findAll()
        ]);
    }

    #[Route('/{id}/edit', name: 'app_facture_fournisseur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FactureFournisseur $factureFournisseur, FactureFournisseurRepository $factureFournisseurRepository): Response
    {
        $form = $this->createForm(FactureFournisseurType::class, $factureFournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $factureFournisseurRepository->add($factureFournisseur);
            return $this->redirectToRoute('app_facture_fournisseur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('facture_fournisseur/edit.html.twig', [
            'facture_fournisseur' => $factureFournisseur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_facture_fournisseur_delete', methods: ['POST'])]
    public function delete(Request $request, FactureFournisseur $factureFournisseur, FactureFournisseurRepository $factureFournisseurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$factureFournisseur->getId(), $request->request->get('_token'))) {
            $factureFournisseurRepository->remove($factureFournisseur);
        }

        return $this->redirectToRoute('app_facture_fournisseur_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/etat/paiement/facture', name: 'app_facture_fournisseur_etat_paiement', methods: ['GET'])]
    public function etatFacture(FactureFournisseur $factureFournisseur, EntityManagerInterface $entityManager): Response
    {
        if($factureFournisseur->getEtatPaiement() == true){
            $factureFournisseur->setEtatPaiement(0);
        }else{
            $factureFournisseur->setEtatPaiement(1);
        }
        $entityManager->flush();
        return $this->render('facture_fournisseur/show.html.twig', [
            'facture_fournisseur' => $factureFournisseur,
        ]);
    }

    #[Route('/{id}/print/facture/fournisseur', name: 'app_print_facture_fournisseur')]
    public function printCommande(FactureFournisseur $factureFournisseur, LCommandeFournisseurRepository $lCommandeFournisseurRepository): Response
    {
        //$commande_clients = $commandeClientRepository->findAll();
        $lCommandes = $lCommandeFournisseurRepository->findAll();

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

        $html = $this->renderView('facture_fournisseur/print.html.twig', [
            'facture_fournisseur' => $factureFournisseur,
            'lcommandes' => $lCommandes
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $date = date('d-m-Y');
        $commandeClientNum = $factureFournisseur->getNumeroFacture();
        // On génère un nom de fichier
        $fichier = 'Facture fournisseur - '.$commandeClientNum;

        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => false
        ]);

        exit();
    } 
}
