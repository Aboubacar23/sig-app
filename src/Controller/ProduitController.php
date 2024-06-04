<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Approvisionnement;
use App\Form\ProduitType;
use App\Form\ApprovisionnementType;
use App\Repository\CommandeClientRepository;
use App\Repository\CommandeFournisseurRepository;
use App\Repository\LCommandeClientRepository;
use App\Repository\LCommandeFournisseurRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/produit')]
class ProduitController extends AbstractController
{
    #[Route('/', name: 'app_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findBy([], ['id'=>'desc']),
        ]);
    }

    #[Route('/new', name: 'app_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProduitRepository $produitRepository, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            if ($image) {
                $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME); 
                $safePhotoname = $slugger->slug($originalePhoto);
                $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                try {
                    $image->move(
                        $this->getParameter('image_produit_directory'),
                        $newPhotoname
                    );
                } catch (FileException $e) {
                }
                $produit->setImage($newPhotoname);
            }

            $produit->setTaux(1);
            $entityManager->persist($produit);
            $entityManager->flush();
            $this->addFlash('success', 'Produit ajouté avec success');

            $produitRepository->add($produit);
            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        $produits = $produitRepository->findAll();
        $count = count($produitRepository->findAll());
        $dernierProduit = end($produits);
        return $this->renderForm('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
            'dernierProduit' => $dernierProduit,
            'nombres' => $count
        ]);
    }

    #[Route('/{id}', name: 'app_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, ProduitRepository $produitRepository, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('image')->getData();
            if ($image) {
                $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME); 
                $safePhotoname = $slugger->slug($originalePhoto);
                $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                try {
                    $image->move(
                        $this->getParameter('image_produit_directory'),
                        $newPhotoname
                    );
                } catch (FileException $e) {
                }
                $produit->setImage($newPhotoname);
            }


            $entityManager->persist($produit);
            $entityManager->flush();

            $produitRepository->add($produit);
            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_produit_delete', methods: ['GET'])]
    public function delete(Request $request, Produit $produit, ProduitRepository $produitRepository, LCommandeClientRepository $commandeClientRepository, LCommandeFournisseurRepository $commandeFournisseurRepository): Response
    {
        $commande_cs = $commandeClientRepository->findAll();
        $commande_fs = $commandeFournisseurRepository->findAll();

        $var_f = 0;
        $var_c = 0;

        for($i = 0; $i < count($commande_cs); $i++){
            if($commande_cs[$i]->getProduit()->getId() == $produit->getId()){
                $var_c = 1;
            }
        }

        for($i = 0; $i < count($commande_fs); $i++){
            if($commande_fs[$i]->getProduit()->getId() == $produit->getId()){
                $var_c = 1;
            }
        }

        if($var_c == 1 or $var_f == 1)
        {
            $this->addFlash('error', "Désole vous ne pouvez pas supprimer cet produit car il a été commander ! Supprimer d'abord la commande du produit: ".$produit->getCodeProduit());
            return $this->redirectToRoute('app_produit_show', [
                'id' => $produit->getId()
            ], Response::HTTP_SEE_OTHER);
        }
        else
        {
            $produitRepository->remove($produit);
            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    #[Route('/{id}/etat/produit', name: 'app_produit_etat', methods: ['GET'])]
    public function etatProduit(Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if($produit->getEtat() == 'Vente'){
            $produit->setEtat('OR Vente');
                    }
        elseif($produit->getEtat() == 'OR Vente'){
            $produit->setEtat('Vente');            
        }

        $entityManager->flush();
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

     #[Route('/{id}/appro', name: 'app_approvisionnement_edit', methods: ['GET', 'POST'])]
    public function appro(Request $request, Produit $produit, ProduitRepository $produitRepository, EntityManagerInterface $entityManager): Response
    {
        $approvisionnement = new Approvisionnement();

        $form = $this->createForm(ApprovisionnementType::class, $approvisionnement);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) { 

                    $newQte = $approvisionnement->getQuantite();
                    $valQte = $newQte + $produit->getQuantite();
                    $produit->setQuantite($valQte);

            $entityManager->persist($produit);
            $entityManager->flush();
            return $this->redirectToRoute('app_approvision', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entrepot/appro.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]); 
    }
}
