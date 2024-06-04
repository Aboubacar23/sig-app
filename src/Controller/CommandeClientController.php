<?php

namespace App\Controller;

use App\Entity\CommandeClient;
use App\Entity\Produit;
use App\Form\CommandeClientType;
use App\Entity\LCommandeClient;
use App\Form\LCommandeClientType;
use App\Repository\CommandeClientRepository;
use App\Repository\FactureClientRepository;
use App\Repository\ProduitRepository;
use App\Repository\LCommandeClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

#[Route('/commande/client')] 
class CommandeClientController extends AbstractController
{
    #[Route('/', name: 'app_commande_client_index', methods: ['GET'])]
    public function index(Request $request, CommandeClientRepository $commandeClientRepository): Response
    {
        $items =  $commandeClientRepository->findBy([], ['id' => 'desc']);

         $commandes = array_filter($items, function ($commande){
             return $commande->isFlag() == 1;
         });

        $session = $request->getSession();
        $session->clear();

        return $this->render('commande_client/index.html.twig', [
            'commande_clients' => $commandes,
        ]);
    }

    #[Route('/liste', name: 'app_commande_client_liste', methods: ['GET'])]
    public function liste(Request $request, CommandeClientRepository $commandeClientRepository): Response
    {
        $tab =  $commandeClientRepository->findBy([], ['id' => 'desc']);
       // dd($tab);
        $commandes = [];
        for($i=0; $i < count($tab); $i++)
        {
            if($tab[$i]->isFlag() != 1){
                array_push($commandes, $tab[$i]);
            }
        }
        $session = $request->getSession();
        $session->clear();
        return $this->render('commande_client/liste.html.twig', [
            'commande_clients' =>$commandes,
        ]);
    }

    #[Route('/new', name: 'app_commande_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CommandeClientRepository $commandeClientRepository, EntityManagerInterface $entityManager, LCommandeClientRepository $lCommandeClientRepository, ProduitRepository $produitRepository): Response
    {

        $commandeAll = $commandeClientRepository->findAll();
        $dernier = end($commandeAll);


        $commande = new CommandeClient();
        $lCommande = new LCommandeClient();

        $form = $this->createForm(CommandeClientType::class, $commande);
        $f = $this->createForm(LCommandeClientType::class, $lCommande);

        $session = $request->getSession();

        $form->handleRequest($request);
        $f->handleRequest($request);

        //declaration d'un tableau de session commande
        if (!$session->has('commande')){
            $session->set('commande', array());
        }

        $session = $request->getSession();
        $choix = '';
        $tab = $session->get('commande', []);
        //$tab = [];

        if ($form->isSubmitted() && $f->isSubmitted()) 
        {

            $choix = $request->get('bt');
            
            if($choix == "Valider")
            {
                 //$em = $this->getDoctrine()->getManager();

                $taille = count($tab);
                for($i = 1; $i <= $taille; $i++)
                {
                    $lCommande = new LCommandeClient();
                    $produit = $produitRepository->findOneBy(array('id'=>$tab[$i]->getProduit()));
                    $lCommande->setProduit($produit);
                    $lCommande->setQuantite($tab[$i]->getQuantite());
                    $lCommande->setTva($tab[$i]->getTva());
                    $lCommande->setLig($i);
                    $lCommande->setRemise($tab[$i]->getRemise());
                    $lCommande->setNumCommande($commande);

                    $entityManager->persist($lCommande);

                }
                
                $entityManager->flush();

                $commande->setEtat(0);
                $commande->setFlag(0);
                $commande->setTypeCommande('Devis Commercial');
                $commandeClientRepository->add($commande);
                $session->clear();
                
                return $this->redirectToRoute('app_commande_client_liste', [], Response::HTTP_SEE_OTHER);
                /**ajout de la commande */
            

                //dd($tab);
            }
            elseif($choix == "Add")
            {
 
                $lig = sizeof($tab)+1;
                $lCommande->setLig($lig);
                $tab[$lig] = $lCommande;
                $session->set('commande', $tab);

            }
        
        }
     //   dd($tab);

        return $this->renderForm('commande_client/new.html.twig', [
            'commande_client' => $commande,
            'lCommande_client' => $lCommande,
            'form' => $form,
            'f' => $f,
            'dernier' => $dernier,
            'lcom' => $tab
        ]);
    }

    #[Route('/{id}', name: 'app_commande_client_show', methods: ['GET'])]
    public function show(CommandeClient $commandeClient, lCommandeClientRepository $lCommandeClientRepository): Response
    {
        return $this->render('commande_client/show.html.twig', [
            'commande_client' => $commandeClient,
            'lcommande' => $lCommandeClientRepository->findAll()
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commande_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,EntityManagerInterface $entityManager,LCommandeClientRepository $lCommandeClientRepository,ProduitRepository $produitRepository, CommandeClient $commandeClient, CommandeClientRepository $commandeClientRepository): Response
    {
        
        $lCommande = new LCommandeClient();

        $form = $this->createForm(CommandeClientType::class, $commandeClient);
        $f = $this->createForm(LCommandeClientType::class, $lCommande);

        $session = $request->getSession();

        $form->handleRequest($request);
        $f->handleRequest($request);

        if (!$session->has('commande')){
            $session->set('commande', array());
        }

        $session = $request->getSession();
        $choix = '';
        $tab = $session->get('commande', []);
        
        if ($form->isSubmitted() && $f->isSubmitted()) 
        {

            $choix = $request->get('bt');
            
            if($choix == "Valider")
            {
                 //$em = $this->getDoctrine()->getManager();

                $taille = count($tab);
                for($i = 1; $i <= $taille; $i++)
                {
                    $lCommande = new LCommandeClient();
                    $produit = $produitRepository->findOneBy(array('id'=>$tab[$i]->getProduit()));
                    $lCommande->setProduit($produit);
                    $lCommande->setQuantite($tab[$i]->getQuantite());
                    $lCommande->setTva($tab[$i]->getTva());
                    $lCommande->setLig($i);
                    $lCommande->setRemise($tab[$i]->getRemise());
                    $lCommande->setNumCommande($commandeClient);

                    $entityManager->persist($lCommande);

                }
                
                $entityManager->flush();

                $commandeClientRepository->add($commandeClient);
                $session->clear();
                
                return $this->redirectToRoute('app_commande_client_show', [
                    'id' => $commandeClient->getId()
                ], Response::HTTP_SEE_OTHER);
                /**ajout de la commande */
            

                //dd($tab);
            }
            elseif($choix == "Add")
            {
 
                $lig = sizeof($tab)+1;
                $lCommande->setLig($lig);
                $lCommande->setNumCommande($commandeClient);
                $tab[$lig] = $lCommande;
                $session->set('commande', $tab);

            }
        
        }
         $lcs = $lCommandeClientRepository->findAll();
        $table_lcs = [];
        for($i = 0; $i< count($lcs);$i++)
        {
            if($lcs[$i]->getNumCommande()->getId() == $commandeClient->getId()){
                array_push($table_lcs, $lcs[$i]);
            }

        }


        $session = $request->getSession();
        $com = $session->get('com_id', $commandeClient->getId());

        return $this->renderForm('commande_client/edit.html.twig', [
            'commande_client' => $commandeClient,
            'form' => $form,
            'f' => $f,
            'lcom' => $tab,
            'lcs' => $table_lcs
        ]); 
    }

    #[Route('/{id}', name: 'app_commande_client_delete', methods: ['POST'])]
    public function delete(Request $request, CommandeClient $commandeClient, CommandeClientRepository $commandeClientRepository, LCommandeClientRepository $lCommandeClientRepository, FactureClientRepository $factureClientRepository): Response
    {

        $commandes = $lCommandeClientRepository->findAll();
        $factures = $factureClientRepository->findAll();

        $var_fc = 0;
        $var_c = 0;

        for($i = 0; $i < count($commandes); $i++){
            if($commandes[$i]->getNumCommande()->getId() == $commandeClient->getId()){
                $var_fc = 1;
            }
        }

        for($i = 0; $i < count($factures); $i++){
            if($factures[$i]->getCommande()->getId() == $commandeClient->getId()){
                $var_c = 1;
            }
        }

        if($var_fc == 1 or $var_c == 1)
        {
            $this->addFlash('error', "Désole vous ne pouvez pas supprimer cette commande car elle a été facture ou produit commandé ! Supprimer d'abord la facture de la commande ou les produits liés: ".$commandeClient->getCodeCommande());
            return $this->redirectToRoute('app_commande_client_show', [
                'id' => $commandeClient->getId()
            ], Response::HTTP_SEE_OTHER);
        }
        else
        {
            if ($this->isCsrfTokenValid('delete'.$commandeClient->getId(), $request->request->get('_token'))) {
                $commandeClientRepository->remove($commandeClient);
            }
            return $this->redirectToRoute('app_commande_client_index', [], Response::HTTP_SEE_OTHER);
        }
    }


    #[Route('/{id}/etat/client', name: 'app_commande_client_etat', methods: ['GET'])]
    public function etatClient(commandeClient $commandeClient, EntityManagerInterface $entityManager, LCommandeClientRepository $lCommandeClientRepository, ProduitRepository $produitRepository): Response
    {
        $tabfiltre = [];
        $lCommandes = $lCommandeClientRepository->findAll();
        $produits = $produitRepository->findAll();

        for ($i=0; $i < count($lCommandes); $i++) { 
            if($lCommandes[$i]->getNumCommande()->getId() == $commandeClient->getId())
            {
                array_push($tabfiltre, $lCommandes[$i]);
            }
            // code...
        }

        if($commandeClient->getEtat() == false){
            for ($i=0; $i < count($produits) ; $i++) { 
                for ($j=0; $j < count($tabfiltre); $j++) {
                    if ($produits[$i]->getId() == $tabfiltre[$j]->getProduit()->getId()) {
                        if($produits[$i]->getQuantite() >= $tabfiltre[$j]->getQuantite()){
                            $valQte = $produits[$i]->getQuantite() - $tabfiltre[$j]->getQuantite();
                            $produits[$i]->setQuantite($valQte);

                        }
                        else
                        {
                            $this->addFlash('error','La quantité commandée du produit '.$tabfiltre[$i]->getProduit()->getLibelle().' est supérieur aux quantités en Stocks');
                           return $this->redirectToRoute('app_commande_client_show',[
                                'id'=> $commandeClient->getId(),    
                                'commande_client' => $commandeClient,
                                'lcommande' => $lCommandeClientRepository->findAll()
                           ], 
                           Response::HTTP_SEE_OTHER); 
                        }
                    }
                }
            }
            $commandeClient->setTypeCommande('Commande Client');
            $commandeClient->setEtat(1);
        }
        else
        {
            for ($i=0; $i < count($produits) ; $i++) { 
                for ($j=0; $j < count($tabfiltre); $j++) {
                    if ($produits[$i]->getId() == $tabfiltre[$j]->getProduit()->getId()) {
                        $valQte = $produits[$i]->getQuantite() + $tabfiltre[$j]->getQuantite();
                        $produits[$i]->setQuantite($valQte);
                    }
                }
            }

            $commandeClient->setTypeCommande('Devis Commercial');
            $commandeClient->setEtat(0);
        }

        $entityManager->flush();
        return $this->render('commande_client/show.html.twig', [
            'commande_client' => $commandeClient,
            'lcommande' => $lCommandeClientRepository->findAll()
        ]);
    }


    #[Route('/delete/{id}', name: 'delete')]
     public function supprime($id, Request $request){
        $session = $request->getSession();
        $Tab= $session->get('commande', []);
        if (array_key_exists($id, $Tab))
        {
            unset($Tab[$id]);
            $session->set('commande',$Tab);
        }
        return $this->redirectToRoute('app_commande_client_new'); 

    }

    #[Route('/deledit/{id}', name: 'app_client_deledit')]
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

        return $this->redirectToRoute('app_commande_client_edit', [
            'id' => $id_com
        ]); 

    } 

    #[Route('/sup/{id}', name: 'app_lclient_delete', methods: ['POST', 'GET'])]
    public function supElement(Request $request, LCommandeClient $lCommandeClient, LCommandeClientRepository $lCommandeClientRepository): Response
    {
        $lCommandeClientRepository->remove($lCommandeClient);
        return $this->redirectToRoute('app_commande_client_edit', [
            'id' => $lCommandeClient->getNumCommande()->getId()
        ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/print/commande/client', name: 'app_print_commande')]
    public function printCommande(CommandeClient $commandeClient, LCommandeClientRepository $lCommandeClientRepository): Response
    {
        //$commande_clients = $commandeClientRepository->findAll();
        $lCommandes = $lCommandeClientRepository->findAll();

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

        $html = $this->renderView('commande_client/print.html.twig', [
            'commande_client' => $commandeClient,
            'lcommandes' => $lCommandes
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $date = date('d-m-Y');
        $commandeClientNum = $commandeClient->getCodeCommande();
        // On génère un nom de fichier
        $fichier = 'Commande - '.$commandeClientNum;

        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => false
        ]);

        exit();
    } 
}
