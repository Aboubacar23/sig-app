<?php

namespace App\Controller;

use App\Entity\Entrepot;
use App\Entity\Produit;
use App\Form\EntrepotType;
use App\Form\ApprovisionnementType;
use App\Repository\EntrepotRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/entrepot')]
class EntrepotController extends AbstractController
{
    #[Route('/', name: 'app_entrepot_index', methods: ['GET'])]
    public function index(EntrepotRepository $entrepotRepository, ProduitRepository $produitRepository): Response
    {
        return $this->render('entrepot/index.html.twig', [
            'entrepots' => $entrepotRepository->findBy([], ['id' => 'desc']),
            'produits' => $produitRepository->findAll()
        ]);
    }

    #[Route('/new', name: 'app_entrepot_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntrepotRepository $entrepotRepository): Response
    {
        $entrepot = new Entrepot();
        $form = $this->createForm(EntrepotType::class, $entrepot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entrepotRepository->add($entrepot);
            return $this->redirectToRoute('app_entrepot_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entrepot/new.html.twig', [
            'entrepot' => $entrepot,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_entrepot_show', methods: ['GET'])]
    public function show(Entrepot $entrepot, ProduitRepository $produitRepository): Response
    {
        return $this->render('entrepot/show.html.twig', [
            'entrepot' => $entrepot,
            'produits' => $produitRepository->findAll()
        ]);
    }

    #[Route('/{id}/edit', name: 'app_entrepot_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Entrepot $entrepot, EntrepotRepository $entrepotRepository): Response
    {
        $form = $this->createForm(EntrepotType::class, $entrepot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entrepotRepository->add($entrepot);
            return $this->redirectToRoute('app_entrepot_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entrepot/edit.html.twig', [
            'entrepot' => $entrepot,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_entrepot_delete', methods: ['POST'])]
    public function delete(Request $request, Entrepot $entrepot, EntrepotRepository $entrepotRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entrepot->getId(), $request->request->get('_token'))) {
            $entrepotRepository->remove($entrepot);
        }

        return $this->redirectToRoute('app_entrepot_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id}/list/produit', name: 'app_entrepot_produit', methods: ['GET'])]
    public function EntrpotProduits(Request $request, Entrepot $entrepot, ProduitRepository $produitRepository): Response
    {
        $produits = $produitRepository->findAll();
        $tab_produits = [];
        $taille = count($produits);
        for ($i=0; $i < $taille ; $i++) { 
            if($produits[$i]->entrepot->getId() == $entrepot->getId()){
                array_push($tab_produits, $produits[$i]);
            }
        }

        return $this->render('entrepot/produit.html.twig', [
            'produit_entrepots' => $tab_produits,
            'entrepot' => $entrepot
        ]);
    }

    #[Route('/{id}/etat/entrepot', name: 'app_entrepot_etat', methods: ['GET'])]
    public function etatEntrepot(Request $request, Entrepot $entrepot, ProduitRepository $produitRepository, EntityManagerInterface $entityManager): Response
    {
        if($entrepot->getEtat() == true){
            $entrepot->setEtat(0);
        }
        else{
            $entrepot->setEtat(1);
        }

        $entityManager->flush();
        return $this->render('entrepot/show.html.twig', [
            'entrepot' => $entrepot,
            'produits' => $produitRepository->findAll()
        ]);
    }

    #[Route('/list/produits', name: 'app_approvision', methods: ['GET', 'POST'])]
    public function produits(Request $request,ProduitRepository $produitRepository): Response
    {
       
        return $this->render('entrepot/index_approvision.html.twig', [
            'produits' => $produitRepository->findAll()
        ]);
    }


}
