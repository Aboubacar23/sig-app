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

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($depenseCamion);
            $entityManager->flush();

            return $this->redirectToRoute('app_depense_camion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('depense_camion/new.html.twig', [
            'depense_camion' => $depenseCamion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_depense_camion_show', methods: ['GET'])]
    public function show(DepenseCamion $depenseCamion): Response
    {
        return $this->render('depense_camion/show.html.twig', [
            'depense_camion' => $depenseCamion,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_depense_camion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DepenseCamion $depenseCamion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DepenseCamionType::class, $depenseCamion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_depense_camion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('depense_camion/edit.html.twig', [
            'depense_camion' => $depenseCamion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_depense_camion_delete', methods: ['POST'])]
    public function delete(Request $request, DepenseCamion $depenseCamion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$depenseCamion->getId(), $request->request->get('_token'))) {
            $entityManager->remove($depenseCamion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_depense_camion_index', [], Response::HTTP_SEE_OTHER);
    }
}
