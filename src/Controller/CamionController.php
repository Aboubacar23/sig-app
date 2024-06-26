<?php

namespace App\Controller;

use App\Entity\Camion;
use App\Form\CamionType;
use App\Repository\CamionRepository;
use App\Service\PrintPdf;
use Doctrine\ORM\EntityManagerInterface;
use Numbers_Words;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/camion')]
class CamionController extends AbstractController
{
    public function __construct(private CamionRepository $camionRepository, private EntityManagerInterface $entityManager)
    {

    }
    #[Route('/index-all-camion', name: 'app_camion_index', methods: ['GET', 'POST'])]
    public function index(CamionRepository $camionRepository, Request $request): Response
    {
        $camion = new Camion();
        $form = $this->createForm(CamionType::class, $camion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->persist($camion);
            $this->entityManager->flush();
            $this->addFlash("success", "Camion ajouté avec succès !");
            return $this->redirectToRoute("app_camion_index");
        }

        return $this->render('camion/index.html.twig', [
            'camions' => $camionRepository->findBy([],['id'=> 'desc']),
            'form' => $form->createView()
        ]);
    }

    #[Route('/new', name: 'app_camion_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $camion = new Camion();
        $form = $this->createForm(CamionType::class, $camion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($camion);
            $entityManager->flush();

            return $this->redirectToRoute('app_camion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('camion/new.html.twig', [
            'camion' => $camion,
            'form' => $form,
        ]);
    }

    #[Route('/show-one-camion/{id}', name: 'app_camion_show', methods: ['GET'])]
    public function show(Camion $camion): Response
    {
        return $this->render('camion/show.html.twig', [
            'camion' => $camion,
        ]);
    }

    #[Route('/modifier/{id}/edit', name: 'app_camion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Camion $camion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CamionType::class, $camion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Camion modifié avec succès !');
            return $this->redirectToRoute('app_camion_show', ['id' => $camion->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('camion/edit.html.twig', [
            'camion' => $camion,
            'form' => $form,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'app_camion_delete', methods: ['GET'])]
    public function delete(Request $request, Camion $camion, EntityManagerInterface $entityManager): Response
    {
        if ($camion) {
            if ($camion->getDepenseCamions() || $camion->getRecetteCamions())
            {
                $this->addFlash('error', 'Désolé ce camion contient des dépenses ou recettes');
            }else
            {
                $entityManager->remove($camion);
                $entityManager->flush();
            }
        }

        return $this->redirectToRoute('app_camion_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/print-facture/{id}', name: 'app_camion_print', methods: ['GET'])]
    public function print(Request $request, Camion $camion,PrintPdf $printPdf): Response
    {

        $words = new Numbers_Words();
        $montant1 = 0;
        $montant2 = 0;
        foreach ($camion->getRecetteCamions() as $item)
        {
            $montant1 = $montant1 + $item->getMontantTransport();
        }

        foreach ($camion->getDepenseCamions() as $item)
        {
            $montant2 = $montant2 + $item->getMontant();
        }
        $montant = $montant1 - $montant2;
        $lettre = $words->toWords($montant, 'fr');
        $html = $this->renderView('camion/print.html.twig', [
            'camion' => $camion,
            'lettre' => $lettre
        ]);

        $name = 'Facture Camion '.$camion;

        return $printPdf->print($html, $name);
    }
}
