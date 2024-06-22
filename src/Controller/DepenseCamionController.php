<?php

namespace App\Controller;

use App\Entity\Camion;
use App\Entity\DepenseCamion;
use App\Form\DepenseCamionType;
use App\Repository\DepenseCamionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/depense-camion')]
class DepenseCamionController extends AbstractController
{
    #[Route('/', name: 'app_depense_camion_index', methods: ['GET'])]
    public function index(DepenseCamionRepository $depenseCamionRepository): Response
    {
        return $this->render('depense_camion/index.html.twig', [
            'depense_camions' => $depenseCamionRepository->findAll(),
        ]);
    }

    #[Route('/new-depense/{id}', name: 'app_depense_camion_new', methods: ['GET', 'POST'])]
    public function new(Camion $camion,Request $request, EntityManagerInterface $entityManager): Response
    {
        $depenseCamion = new DepenseCamion();
        $form = $this->createForm(DepenseCamionType::class, $depenseCamion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $depenseCamion->setCamion($camion);
            $entityManager->persist($depenseCamion);
            $entityManager->flush();
            $this->addFlash('success', 'Dépense ajouté avec succès !');
            return $this->redirectToRoute('app_camion_show', ['id' => $camion->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('depense_camion/new.html.twig', [
            'depense_camion' => $depenseCamion,
            'form' => $form,
        ]);
    }

    #[Route('/show-depense/{id}', name: 'app_depense_camion_show', methods: ['GET'])]
    public function show(DepenseCamion $depenseCamion): Response
    {
        return $this->render('depense_camion/show.html.twig', [
            'depense_camion' => $depenseCamion,
        ]);
    }

    #[Route('/modifier/{id}/edit', name: 'app_depense_camion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DepenseCamion $depenseCamion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DepenseCamionType::class, $depenseCamion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('success', 'Dépense modifié avec succès !');
            $entityManager->flush();
            return $this->redirectToRoute('app_camion_show', ['id' => $depenseCamion->getCamion()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('depense_camion/edit.html.twig', [
            'depense_camion' => $depenseCamion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_depense_camion_delete', methods: ['GET'])]
    public function delete(Request $request, DepenseCamion $depenseCamion, EntityManagerInterface $entityManager): Response
    {
        $id = $depenseCamion->getCamion()->getId();

        if ($depenseCamion->getId())
        {

            $entityManager->remove($depenseCamion);
            $entityManager->flush();
            $this->addFlash('error', 'Dépense supprimé avec succès !');
        }

        return $this->redirectToRoute('app_camion_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }
}
