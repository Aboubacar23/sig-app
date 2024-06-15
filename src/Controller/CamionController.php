<?php

namespace App\Controller;

use App\Entity\Camion;
use App\Form\CamionType;
use App\Repository\CamionRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/{id}', name: 'app_camion_show', methods: ['GET'])]
    public function show(Camion $camion): Response
    {
        return $this->render('camion/show.html.twig', [
            'camion' => $camion,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_camion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Camion $camion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CamionType::class, $camion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_camion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('camion/edit.html.twig', [
            'camion' => $camion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_camion_delete', methods: ['POST'])]
    public function delete(Request $request, Camion $camion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$camion->getId(), $request->request->get('_token'))) {
            $entityManager->remove($camion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_camion_index', [], Response::HTTP_SEE_OTHER);
    }
}
