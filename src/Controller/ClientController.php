<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use App\Repository\CommandeClientRepository;
use App\Repository\FactureClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/client')]
class ClientController extends AbstractController
{
    #[Route('/', name: 'app_client_index', methods: ['GET'])]
    public function index(ClientRepository $clientRepository): Response
    {
        return $this->render('client/index.html.twig', [
            'clients' => $clientRepository->findBy([], ['id'=> 'desc']),
        ]);
    }

    #[Route('/new', name: 'app_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ClientRepository $clientRepository): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientRepository->add($client);
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        $allClient = $clientRepository->findAll();
        $dernier = end($allClient); 
        return $this->renderForm('client/new.html.twig', [
            'client' => $client,
            'form' => $form,
            'dernier' => $dernier
        ]);
    }

    #[Route('/{id}', name: 'app_client_show', methods: ['GET'])]
    public function show(Client $client): Response
    {
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Client $client, ClientRepository $clientRepository): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientRepository->add($client);
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/edit.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_client_delete', methods: ['POST'])]
    public function delete(Request $request, Client $client, ClientRepository $clientRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $clientRepository->remove($client);
        }

        return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/etat/client', name: 'app_client_etat', methods: ['GET'])]
    public function etatClient(Client $client, EntityManagerInterface $entityManager): Response
    {
        if($client->getEtat() == true){
            $client->setEtat(0);
        }else{
            $client->setEtat(1);
        }
        $entityManager->flush();
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }

    #[Route('/{id}/compte', name: 'app_client_compte', methods: ['GET'])]
    public function compte(Client $client, CommandeClientRepository $commandeClientRepository): Response
    {
        return $this->render('client/compte.html.twig', [
            'client' => $client,
            'commandes' => $commandeClientRepository->findAll()
        ]);
    }

    #[Route('/{id}/facture/compte', name: 'app_client_facture', methods: ['GET'])]
    public function facture(Client $client, FactureClientRepository $factureClientRepository): Response
    { 
        return $this->render('client/facture.html.twig', [
            'client' => $client,
            'facture_clients' => $factureClientRepository->findAll()
        ]);
    }
}
