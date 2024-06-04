<?php

namespace App\Controller;

use App\Entity\Versement;
use App\Form\VersementType;
use App\Repository\VersementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/versement')]
class VersementController extends AbstractController
{
    #[Route('/', name: 'app_versement_index', methods: ['GET'])]
    public function index(VersementRepository $versementRepository): Response
    {
        return $this->render('versement/index.html.twig', [
            'versements' => $versementRepository->findBy([], ['id' => 'desc']),
        ]);
    }

    #[Route('/new', name: 'app_versement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VersementRepository $versementRepository): Response
    {
        $versement = new Versement();
        $form = $this->createForm(VersementType::class, $versement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $versement->setAvance(1);
            $versementRepository->add($versement, true); 

            return $this->redirectToRoute('app_versement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('versement/new.html.twig', [
            'versement' => $versement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_versement_show', methods: ['GET'])]
    public function show(Versement $versement): Response
    {
        return $this->render('versement/show.html.twig', [
            'versement' => $versement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_versement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Versement $versement, VersementRepository $versementRepository): Response
    {
        $form = $this->createForm(VersementType::class, $versement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $versementRepository->add($versement, true);

            return $this->redirectToRoute('app_versement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('versement/edit.html.twig', [
            'versement' => $versement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_versement_delete', methods: ['POST'])]
    public function delete(Request $request, Versement $versement, VersementRepository $versementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$versement->getId(), $request->request->get('_token'))) {
            $versementRepository->remove($versement, true);
        }

        return $this->redirectToRoute('app_versement_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/facture/liste', name: 'versment_facture', methods: ['GET','POST'])]
    public function versementFacture(VersementRepository $versementRepository): Response
    {
        $versements = $versementRepository->findAll();
           
        return $this->render('versement/versement_facture.html.twig', [
            'versement_factures' => $versements,
        ]);
    }
}
