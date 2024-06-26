<?php

namespace App\Controller;

use App\Entity\Banque;
use App\Form\BanqueType;
use App\Repository\BanqueRepository;
use App\Repository\VersementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/banque')]
class BanqueController extends AbstractController
{
    #[Route('/', name: 'app_banque_index', methods: ['GET'])]
    public function index(BanqueRepository $banqueRepository): Response
    {
        return $this->render('banque/index.html.twig', [
            'banques' => $banqueRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_banque_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BanqueRepository $banqueRepository): Response
    {
        $banque = new Banque();
        $form = $this->createForm(BanqueType::class, $banque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $banqueRepository->add($banque, true);

            return $this->redirectToRoute('app_banque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('banque/new.html.twig', [
            'banque' => $banque,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_banque_show', methods: ['GET'])]
    public function show(Banque $banque): Response
    {
        return $this->render('banque/show.html.twig', [
            'banque' => $banque,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_banque_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Banque $banque, BanqueRepository $banqueRepository): Response
    {
        $form = $this->createForm(BanqueType::class, $banque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $banqueRepository->add($banque, true);

            return $this->redirectToRoute('app_banque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('banque/edit.html.twig', [
            'banque' => $banque,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_banque_delete', methods: ['POST'])]
    public function delete(Request $request, Banque $banque, BanqueRepository $banqueRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$banque->getId(), $request->request->get('_token'))) {
            $banqueRepository->remove($banque, true);
        }

        return $this->redirectToRoute('app_banque_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/historique', name: 'app_banque_historique', methods: ['GET'])]
    public function historique(Banque $banque, VersementRepository $versementRepository): Response
    {
        return $this->render('banque/historique.html.twig', [
            'banque' => $banque,
            'versements' => $versementRepository->findAll()
        ]);
    }
}
