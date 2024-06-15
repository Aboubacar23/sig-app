<?php

namespace App\Controller;

use App\Entity\Camion;
use App\Entity\RecetteCamion;
use App\Form\RecetteCamionType;
use App\Repository\RecetteCamionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/recette-camion')]
class RecetteCamionController extends AbstractController
{
    #[Route('/', name: 'app_recette_camion_index', methods: ['GET'])]
    public function index(RecetteCamionRepository $recetteCamionRepository): Response
    {
        return $this->render('recette_camion/index.html.twig', [
            'recette_camions' => $recetteCamionRepository->findAll(),
        ]);
    }

    #[Route('/new-recette/{id}', name: 'app_recette_camion_new', methods: ['GET', 'POST'])]
    public function new(Camion $camion,Request $request, EntityManagerInterface $entityManager): Response
    {
        $recetteCamion = new RecetteCamion();
        $form = $this->createForm(RecetteCamionType::class, $recetteCamion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recetteCamion->setCamion($camion);
            $entityManager->persist($recetteCamion);
            $entityManager->flush();

            return $this->redirectToRoute('app_camion_show', ['id' => $camion->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recette_camion/new.html.twig', [
            'recette_camion' => $recetteCamion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_recette_camion_show', methods: ['GET'])]
    public function show(RecetteCamion $recetteCamion): Response
    {
        return $this->render('recette_camion/show.html.twig', [
            'recette_camion' => $recetteCamion,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_recette_camion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RecetteCamion $recetteCamion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RecetteCamionType::class, $recetteCamion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_recette_camion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recette_camion/edit.html.twig', [
            'recette_camion' => $recetteCamion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_recette_camion_delete', methods: ['POST'])]
    public function delete(Request $request, RecetteCamion $recetteCamion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recetteCamion->getId(), $request->request->get('_token'))) {
            $entityManager->remove($recetteCamion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_recette_camion_index', [], Response::HTTP_SEE_OTHER);
    }
}
