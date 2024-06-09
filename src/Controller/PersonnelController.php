<?php

namespace App\Controller;

use App\Entity\Personnel;
use App\Form\PersonnelType;
use App\Repository\PersonnelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/personnel')]
class PersonnelController extends AbstractController
{
    #[Route('/index', name: 'app_personnel_index', methods: ['GET'])]
    public function index(PersonnelRepository $personnelRepository): Response
    {
        return $this->render('personnel/index.html.twig', [
            'personnels' => $personnelRepository->findBy([], ['id' => 'desc']),
        ]);
    }

    #[Route('/new-personnel', name: 'app_personnel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PersonnelRepository $personnelRepository, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $personnel = new Personnel();
        $form = $this->createForm(PersonnelType::class, $personnel);
        $form->handleRequest($request);
        $allPersonnel = $personnelRepository->findAll();
        $dernier = end($allPersonnel);
        $nextId = $dernier ? $dernier->getId() + 1 : 1;

        $code_env = $_ENV['CODE_EMP'];
        $dateJour = date('Y');
        $num = $code_env.''.$dateJour.'-'.$nextId;

        if ($form->isSubmitted() && $form->isValid()) {

           $this->handleImageUpload($form, $personnel, $slugger);

            $entityManager->persist($personnel);
            $entityManager->flush();
            $this->addFlash('success', 'Personnel ajouté avec success');

            $personnelRepository->add($personnel);
            return $this->redirectToRoute('app_personnel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('personnel/new.html.twig', [
            'personnel' => $personnel,
            'form' => $form,
            'num' => $num
        ]);
    }

    #[Route('/show-details/{id}', name: 'app_personnel_show', methods: ['GET'])]
    public function show(Personnel $personnel): Response
    {
        return $this->render('personnel/show.html.twig', [
            'personnel' => $personnel,
        ]);
    }

    #[Route('/modifier-personnel/{id}/edit', name: 'app_personnel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Personnel $personnel, PersonnelRepository $personnelRepository,EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(PersonnelType::class, $personnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->handleImageUpload($form, $personnel, $slugger);

            $entityManager->persist($personnel);
            $entityManager->flush();
            $this->addFlash('success', 'Personnel modifié avec success');

            $personnelRepository->add($personnel);
            return $this->redirectToRoute('app_personnel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('personnel/edit.html.twig', [
            'personnel' => $personnel,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_personnel_delete', methods: ['GET'])]
    public function delete(Request $request, Personnel $personnel, PersonnelRepository $personnelRepository): Response
    {
        if ($personnel)
        {
            $personnelRepository->remove($personnel);
        }

        $this->addFlash('success', 'Personnel modifié avec success');
        return $this->redirectToRoute('app_personnel_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * Gère l'upload de l'image du personnel
     */
    private function handleImageUpload($form, $personnel, $slugger): void
    {
        $image = $form->get('image')->getData();
        if ($image) {
            $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();

            try {
                $image->move(
                    $this->getParameter('image_employee_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // Gérer l'exception si quelque chose se passe pendant l'upload du fichier
            }

            $personnel->setImage($newFilename);
        }
    }
}
