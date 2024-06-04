<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Personnel;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Repository\PersonnelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/users')]
class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, PersonnelRepository $personnelRepository, SluggerInterface $slugger): Response
    {
        $user = new User();
        $personnel = new Personnel();

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            //génération automatique du code employée
            $allPersonnel = $personnelRepository->findAll();
            $dernier = end($allPersonnel);
            $num = 0;
            if( $dernier == null)
            {
                $val = 1;
            }
            else{
                $val = $dernier->getId() + 1;
            }

            $dateJour = date('Ym');
            $num = 'GSP-'.$dateJour.$val;

            //insertion de l'image
            $image = $form->get('image')->getData();
            if ($image) {
                $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME); 
                $safePhotoname = $slugger->slug($originalePhoto);
                $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                try {
                    $image->move(
                        $this->getParameter('image_employee_directory'),
                        $newPhotoname
                    );
                } catch (FileException $e) {
                }
                $user->setImage($newPhotoname);
                $personnel->setImage($newPhotoname);
            }

            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Administreteur ajouté avec success');

            $personnel->setCodePersonnel($num);
            $personnel->setNom($user->getNom());
            $personnel->setPrenom($user->getPrenom());
            $personnel->setEmail($user->getEmail());
            $personnel->setTel($user->getTel());
            $personnel->setPays($user->getPays());
            $personnel->setVille($user->getVille());

            $entityManager->persist($personnel);
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_user_index');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/index', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findBy([], ['id'=> 'desc']);
        return $this->render('registration/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/edit/{id}', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(User $user,Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
   
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            
                        //insertion de l'image
            $image = $form->get('image')->getData();
            if ($image) {
                $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME); 
                $safePhotoname = $slugger->slug($originalePhoto);
                $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                try {
                    $image->move(
                        $this->getParameter('image_employee_directory'),
                        $newPhotoname
                    );
                } catch (FileException $e) {
                }
                $user->setImage($newPhotoname);
            }

            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Admin modifier avec success');


            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_user_index');
        }

        return $this->render('registration/edit.html.twig', [
            'user' => $user,
            'registrationForm' => $form->createView(),
        ]);
    }


    #[Route('/show/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user){
        return $this->render('registration/show.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user);
        }

        return $this->redirectToRoute('app_personnel_index', [], Response::HTTP_SEE_OTHER);
    }
}
