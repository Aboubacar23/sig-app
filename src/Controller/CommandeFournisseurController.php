<?php

namespace App\Controller;

use App\Entity\CommandeFournisseur;
use App\Entity\FactureFournisseur;
use App\Entity\LCommandeFournisseur;
use App\Form\CommandeFournisseurType;
use App\Form\LCommandeFournisseurType;
use App\Repository\CommandeFournisseurRepository;
use App\Repository\FactureFournisseurRepository;
use App\Repository\LCommandeFournisseurRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\EntityManagerProvider;
use Dompdf\Dompdf;
use Dompdf\Options;

#[Route('/commande/fournisseur')]
class CommandeFournisseurController extends AbstractController
{
    #[Route('/', name: 'app_commande_fournisseur_index', methods: ['GET'])]
    public function index(CommandeFournisseurRepository $commandeFournisseurRepository, Request $request): Response
    {

        //dd($commandeFournisseurRepository->findBy([], ['id' => 'desc']));
        
        $session = $request->getSession();
        $session->clear();
        return $this->render('commande_fournisseur/index.html.twig', [
            'commande_fournisseurs' => $commandeFournisseurRepository->findBy([], ['id' => 'desc']),
        ]); 
    }

    #[Route('/new', name: 'app_commande_fournisseur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CommandeFournisseurRepository $commandeFournisseurRepository, ProduitRepository $produitRepository, EntityManagerInterface $entityManager): Response
    {

        $commandeAll = $commandeFournisseurRepository->findAll();
        $derniereCommande = end($commandeAll);

        $commandeFournisseur = new CommandeFournisseur();
        $lCommandeFournisseur = new LCommandeFournisseur();

        $form = $this->createForm(CommandeFournisseurType::class, $commandeFournisseur);
        $f = $this->createForm(LCommandeFournisseurType::class, $lCommandeFournisseur);

        $session = $request->getSession();

        $form->handleRequest($request);
        $f->handleRequest($request);

        if (!$session->has('commande')){
            $session->set('commande', array());
        }

        $session = $request->getSession();
        $choix = '';
        $tab = $session->get('commande', []);
        //$tab = [];


        if ($form->isSubmitted() && $f->isSubmitted()) {

             $choix = $request->get('bt');

            if($choix == "Valider")
            {
                 //$em = $this->getDoctrine()->getManager();

                $taille = count($tab);
                for($i = 1; $i <= $taille; $i++)
                {
                    $lCommande = new LCommandeFournisseur();
                    $produit = $produitRepository->findOneBy(array('id'=>$tab[$i]->getProduit()));
                    $lCommande->setProduit($produit);
                    $lCommande->setQuantite($tab[$i]->getQuantite());
                    $lCommande->setTva($tab[$i]->getTva());
                    $lCommande->setLig($i);
                    $lCommande->setRemise($tab[$i]->getRemise());
                    $lCommande->setNumCommande($commandeFournisseur);

                    $entityManager->persist($lCommande);

                }
                
                $entityManager->flush();

                $commandeFournisseur ->setEtat(1);
                $commandeFournisseurRepository->add($commandeFournisseur);
                $session->clear();

                return $this->redirectToRoute('app_commande_fournisseur_index', [], Response::HTTP_SEE_OTHER);
                /**ajout de la commande */
            

                //dd($tab);
            }
            elseif($choix == "Add")
            {

                $lig = sizeof($tab)+1;
                $lCommandeFournisseur->setLig($lig);
                //dd($lCommandeClient);
                $tab[$lig] = $lCommandeFournisseur;
                $session->set('commande', $tab);

            }
        }

        return $this->renderForm('commande_fournisseur/new.html.twig', [
            'commande_fournisseur' => $commandeFournisseur,
            'lCommande_fournisseur' => $lCommandeFournisseur,
            'form' => $form,
            'f' => $f,
            'derniereCommande' => $derniereCommande,
            'lcom' => $tab
        ]);
    }


    #[Route('/{id}', name: 'app_commande_fournisseur_show', methods: ['GET'])]
    public function show(CommandeFournisseur $commandeFournisseur, lCommandeFournisseurRepository $lCommandeClientRepository): Response
    {
        return $this->render('commande_fournisseur/show.html.twig', [
            'commande_fournisseur' => $commandeFournisseur,
            'lcommande' => $lCommandeClientRepository->findAll()
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commande_fournisseur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,LCommandeFournisseurRepository $lCommandeFournisseurRepository, ProduitRepository $produitRepository,CommandeFournisseur $commandeFournisseur, CommandeFournisseurRepository $commandeFournisseurRepository, EntityManagerInterface $entityManager): Response
    {
      
        $lCommandeFournisseur = new LCommandeFournisseur();

        $form = $this->createForm(CommandeFournisseurType::class, $commandeFournisseur);
        $f = $this->createForm(LCommandeFournisseurType::class, $lCommandeFournisseur);

        $session = $request->getSession();

        $form->handleRequest($request);
        $f->handleRequest($request);


        if (!$session->has('commande')){
            $session->set('commande', array());
        }

        $session = $request->getSession();
        $choix = '';
        $tab = $session->get('commande', []);

        if ($form->isSubmitted() && $f->isSubmitted()) {
            
            $choix = $request->get('bt');

            if($choix == "Valider")
            {
                $taille = count($tab);
                for($i = 1; $i <= $taille; $i++)
                {
                    $lCommande = new LCommandeFournisseur();
                    $produit = $produitRepository->findOneBy(array('id'=>$tab[$i]->getProduit()));
                    $lCommande->setProduit($produit);
                    $lCommande->setQuantite($tab[$i]->getQuantite());
                    $lCommande->setTva($tab[$i]->getTva());
                    $lCommande->setLig($i);
                    $lCommande->setRemise($tab[$i]->getRemise());
                    $lCommande->setNumCommande($commandeFournisseur);

                    $entityManager->persist($lCommande);

                }
                
                $entityManager->flush();

                $commandeFournisseur ->setEtat(1);
                $commandeFournisseurRepository->add($commandeFournisseur);
                $session->clear();

                return $this->redirectToRoute('app_commande_fournisseur_show', [
                    'id' => $commandeFournisseur->getId()
                ], Response::HTTP_SEE_OTHER);

            }
            elseif($choix == "Add")
            {
                $lig = sizeof($tab)+1;
                $lCommandeFournisseur->setLig($lig);
                $lCommandeFournisseur->setNumCommande($commandeFournisseur);
                //dd($lCommandeClient);
                $tab[$lig] = $lCommandeFournisseur;
                $session->set('commande', $tab);

            }
        }

        //dd($tab);
        $lcs = $lCommandeFournisseurRepository->findAll();
        $table_lcs = [];
        for($i = 0; $i< count($lcs);$i++)
        {
            if($lcs[$i]->getNumCommande()->getId() == $commandeFournisseur->getId()){
                array_push($table_lcs, $lcs[$i]);
            }

        }


        $session = $request->getSession();
        $com = $session->get('com_id', $commandeFournisseur->getId());
       // dd($com);
        return $this->renderForm('commande_fournisseur/edit.html.twig', [
            'commande_fournisseur' => $commandeFournisseur,
            'lCommande_fournisseur' => $lCommandeFournisseur,
            'form' => $form,
            'f' => $f,
            'lcom' => $tab,
            'lcs' => $table_lcs,
            'com' => $com
        ]);
    }

    #[Route('/{id}', name: 'app_commande_fournisseur_delete', methods: ['POST'])]
    public function delete(Request $request, CommandeFournisseur $commandeFournisseur, CommandeFournisseurRepository $commandeFournisseurRepository, LCommandeFournisseurRepository $lCommandeFournisseurRepository, FactureFournisseurRepository $factureFournisseur): Response
    {
        $commandes = $lCommandeFournisseurRepository->findAll();
        $factures = $factureFournisseur->findAll();

        $var_fa = 0;
        $var_c = 0;

        for($i = 0; $i < count($commandes); $i++){
            if($commandes[$i]->getNumCommande()->getId() == $commandeFournisseur->getId()){
                $var_c = 1;
            }
        }

        for($i = 0; $i < count($factures); $i++){
            if($factures[$i]->getCommande()->getId() == $commandeFournisseur->getId()){
                $var_fa = 1;
            }
        }

        if($var_c == 1 or $var_fa == 1)
        {
            $this->addFlash('error', "Désole vous ne pouvez pas supprimer cette commande car elle a été facture ! Supprimer d'abord la facture de la commande : ".$commandeFournisseur->getNumeroCommande());
            return $this->redirectToRoute('app_commande_fournisseur_show', [
                'id' => $commandeFournisseur->getId()
            ], Response::HTTP_SEE_OTHER);
        }
        else
        {
            if ($this->isCsrfTokenValid('delete'.$commandeFournisseur->getId(), $request->request->get('_token'))) {
                $commandeFournisseurRepository->remove($commandeFournisseur);
            }

        }

        return $this->redirectToRoute('app_commande_fournisseur_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/etat/fournisseur', name: 'app_commande_fournisseur_etat', methods: ['GET'])]
    public function etatClient(CommandeFournisseur $commandeFournisseur,LCommandeFournisseurRepository $lCommandeClientRepository, EntityManagerInterface $entityManager): Response
    {
        if($commandeFournisseur->getEtat() == true){
            $commandeFournisseur->setEtat(0);
        }else{
            $commandeFournisseur->setEtat(1);
        }
        $entityManager->flush();
        return $this->render('commande_fournisseur/show.html.twig', [
            'commande_fournisseur' => $commandeFournisseur,
            'lcommande' => $lCommandeClientRepository->findAll()
        ]);
    }


    #[Route('/delete/{id}', name: 'app_four_delete')]
    public function supprime($id, Request $request)
    {
        $session = $request->getSession();
        $tab= $session->get('commande', []);
        if (array_key_exists($id, $tab))
        {
            unset($tab[$id]);
            $session->set('commande',$tab);
        }
        return $this->redirectToRoute('app_commande_fournisseur_new'); 

    } 


    #[Route('/sup/{id}', name: 'app_lcommande_delete', methods: ['POST', 'GET'])]
    public function supElement(Request $request, LCommandeFournisseur $lCommandeFournisseur, LCommandeFournisseurRepository $lCommandeFournisseurRepository): Response
    {
        $lCommandeFournisseurRepository->remove($lCommandeFournisseur);
        return $this->redirectToRoute('app_commande_fournisseur_edit', [
            'id' => $lCommandeFournisseur->getNumCommande()->getId()
        ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/deledit/{id}', name: 'app_four_deledit')]
    public function deledit($id, Request $request){
        $session = $request->getSession();
        $tab= $session->get('commande', []);
        $id_com= 0;
        //dd($id);
        if (array_key_exists($id, $tab))
        {
            $id_com = $tab[$id]->getNumCommande()->getId();
            unset($tab[$id]);
            $session->set('commande',$tab);
            
        }

        return $this->redirectToRoute('app_commande_fournisseur_edit', [
            'id' => $id_com
        ]); 

    } 

    #[Route('/{id}/print/commande/fournisseur', name: 'app_print_commande_fournisseur')]
    public function printCommande(CommandeFournisseur $commandeFournisseur, LCommandeFournisseurRepository $lCommandeFournisseurRepository): Response
    {
        //$commande_clients = $commandeClientRepository->findAll();
        $lCommandes = $lCommandeFournisseurRepository->findAll();

        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Times New Roman');
        $pdfOptions->setIsRemoteEnabled(true);
        $pdfOptions->setIsHtml5ParserEnabled(true);

        // On instancie Dompdf
        $dompdf = new Dompdf($pdfOptions);

        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);

        $dompdf->setHttpContext($context);

        $html = $this->renderView('commande_fournisseur/print.html.twig', [
            'commande_fournisseur' => $commandeFournisseur,
            'lcommandes' => $lCommandes
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $date = date('d-m-Y');
        $commandeClientNum = $commandeFournisseur->getNumeroCommande();
        // On génère un nom de fichier
        $fichier = 'Commande fournisseur - '.$commandeClientNum;

        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => false
        ]);

        exit();
    } 
}
