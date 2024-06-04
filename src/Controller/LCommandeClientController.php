<?php

namespace App\Controller;

use App\Entity\LCommandeClient;
use App\Form\LCommandeClientType;
use App\Repository\LCommandeClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/l/commande/client')]
class LCommandeClientController extends AbstractController
{
    #[Route('/', name: 'app_l_commande_client_index', methods: ['GET'])]
    public function index(LCommandeClientRepository $lCommandeClientRepository): Response
    {
        return $this->render('l_commande_client/index.html.twig', [
            'l_commande_clients' => $lCommandeClientRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_l_commande_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LCommandeClientRepository $lCommandeClientRepository): Response
    {
        $lCommandeClient = new LCommandeClient();
        $form = $this->createForm(LCommandeClientType::class, $lCommandeClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lCommandeClientRepository->add($lCommandeClient);
            return $this->redirectToRoute('app_l_commande_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('l_commande_client/new.html.twig', [
            'l_commande_client' => $lCommandeClient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_l_commande_client_show', methods: ['GET'])]
    public function show(LCommandeClient $lCommandeClient): Response
    {
        return $this->render('l_commande_client/show.html.twig', [
            'l_commande_client' => $lCommandeClient,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_l_commande_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LCommandeClient $lCommandeClient, LCommandeClientRepository $lCommandeClientRepository): Response
    {
        $form = $this->createForm(LCommandeClientType::class, $lCommandeClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lCommandeClientRepository->add($lCommandeClient);
            return $this->redirectToRoute('app_l_commande_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('l_commande_client/edit.html.twig', [
            'l_commande_client' => $lCommandeClient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_l_commande_client_delete', methods: ['POST'])]
    public function delete(Request $request, LCommandeClient $lCommandeClient, LCommandeClientRepository $lCommandeClientRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lCommandeClient->getId(), $request->request->get('_token'))) {
            $lCommandeClientRepository->remove($lCommandeClient);
        }

        return $this->redirectToRoute('app_l_commande_client_index', [], Response::HTTP_SEE_OTHER);
    }
}
