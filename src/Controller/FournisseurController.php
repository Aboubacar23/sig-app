<?php

namespace App\Controller;

use App\Entity\Fournisseur;
use App\Form\FournisseurType;
use App\Repository\FournisseurRepository;
use App\Repository\CommandeFournisseurRepository;
use App\Repository\FactureFournisseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/fournisseur')]
class FournisseurController extends AbstractController
{
    #[Route('/index-fournisseurs', name: 'app_fournisseur_index', methods: ['GET'])]
    public function index(FournisseurRepository $fournisseurRepository): Response
    {
        return $this->render('fournisseur/index.html.twig', [
            'fournisseurs' => $fournisseurRepository->findAll(),
        ]);
    }

    #[Route('/new-fournisseur', name: 'app_fournisseur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FournisseurRepository $fournisseurRepository): Response
    {
        $fournisseur = new Fournisseur();
        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fournisseurRepository->add($fournisseur);
            return $this->redirectToRoute('app_fournisseur_index', [], Response::HTTP_SEE_OTHER);
        }

        $fournisseurs =  $fournisseurRepository->findAll();
        $dernierFournisseur =  end($fournisseurs);
        return $this->renderForm('fournisseur/new.html.twig', [
            'fournisseur' => $fournisseur,
            'form' => $form,
            'dernierFournisseur' => $dernierFournisseur
        ]);
    }

    #[Route('/show-fournisseur/{id}', name: 'app_fournisseur_show', methods: ['GET'])]
    public function show(Fournisseur $fournisseur, CommandeFournisseurRepository $commandeFournisseurRepository): Response
    {
        $nombres = count($commandeFournisseurRepository->findByFournisseur($fournisseur));
        return $this->render('fournisseur/show.html.twig', [
            'fournisseur' => $fournisseur,
            'nombres' => $nombres
        ]);
    }

    #[Route('/existe-fournisseur/{id}/edit', name: 'app_fournisseur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Fournisseur $fournisseur, FournisseurRepository $fournisseurRepository): Response
    {
        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fournisseurRepository->add($fournisseur);
            return $this->redirectToRoute('app_fournisseur_show', ['id' => $fournisseur->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fournisseur/edit.html.twig', [
            'fournisseur' => $fournisseur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_fournisseur_delete', methods: ['POST'])]
    public function delete(Request $request, Fournisseur $fournisseur, FournisseurRepository $fournisseurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fournisseur->getId(), $request->request->get('_token'))) {
            $fournisseurRepository->remove($fournisseur);
        }

        return $this->redirectToRoute('app_fournisseur_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/existe-fournisseur/{id}/etat/fournisseur', name: 'app_fournisseur_etat', methods: ['GET'])]
    public function etatClient(Fournisseur $fournisseur, EntityManagerInterface $entityManager, CommandeFournisseurRepository $commandeFournisseurRepository): Response
    {
        // Bascule l'état du fournisseur entre actif (1) et inactif (0)
        $fournisseur->setEtat($fournisseur->getEtat() ? 0 : 1);

        $nombres = count($commandeFournisseurRepository->findByFournisseur($fournisseur));
        $entityManager->flush();

        // Attribution de la valeur à $mot basée sur l'état du fournisseur
        $mot = $fournisseur->getEtat() == 1 ? 'Activer' : 'Désactiver';

        $this->addFlash('message', "Vous avez modifiez l'état du fournisseur à : ".$mot);

        return $this->render('fournisseur/show.html.twig', [
            'fournisseur' => $fournisseur,
            'nombres' => $nombres,
        ]);
    }

    #[Route('/existe-fournisseur/{id}/compte', name: 'app_fournisseur_compte', methods: ['GET'])]
    public function compte(Fournisseur $fournisseur, CommandeFournisseurRepository $commandeFournisseurRepository): Response
    {
        $commandes = $commandeFournisseurRepository->findByFournisseur($fournisseur);
        return $this->render('fournisseur/comptes.html.twig', [
            'fournisseur' => $fournisseur,
            'commandes' => $commandes
        ]);
    }

    #[Route('/existe-fournisseur/{id}/facture/compte', name: 'app_fournisseur_facture', methods: ['GET'])]
    public function facture(Fournisseur $fournisseur, FactureFournisseurRepository $factureFournisseurRepository): Response
    { 
        return $this->render('fournisseur/facture.html.twig', [
            'fournisseur' => $fournisseur,
            'facture_fournisseurs' => $factureFournisseurRepository->findAll()
        ]);
    }
}
