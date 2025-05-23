<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminProfileType;
use App\Form\UserType;
use App\Form\HotelType;
use App\Form\ClientProfileType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\HotelRepository;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserController extends AbstractController
{
 #[IsGranted('ROLE_OWNER')]
    #[Route('/admin/user', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findUsersWithHotel(),
        ]);
    }
    #[IsGranted('ROLE_OWNER')]
    #[Route('/admin', name: 'admin_dashboard', methods: ['GET'])]
    public function dashboard(): Response
    {
        return $this->redirectToRoute('app_user_index');
    }


    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/user/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $user->setRoles(['ROLE_OWNER']);

        $now = new \DateTimeImmutable();
        $user->setCreatedAt($now);
        $user->setUpdatedAt($now);
        $user->setIsActive(true);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

 #[IsGranted('ROLE_OWNER')]
    #[Route('/admin/user/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

 #[IsGranted('ROLE_OWNER')]
    #[Route('/admin/user/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

 #[IsGranted('ROLE_OWNER')]
    #[Route('/admin/user/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/admin/profil', name: 'admin_profil', methods: ['GET', 'POST'])]
    public function adminProfil(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher): Response
    {
        /** @var User $admin */
        $admin = $this->getUser();

        $form = $this->createForm(AdminProfileType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPassword = $form->get('password')->getData();

            if ($newPassword) {
                $hashedPassword = $hasher->hashPassword($admin, $newPassword);
                $admin->setPassword($hashedPassword);
            }

            $admin->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->flush();

            $this->addFlash('success', 'Votre profil a bien été mis à jour.');

            return $this->redirectToRoute('admin_profil');
        }

        return $this->render('admin/admin_profil.html.twig', [
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_OWNER')]
    #[Route('/admin/mon-hotel', name: 'owner_hotel')]
    public function monHotel(): Response
    {
        /** @var User $owner */
        $owner = $this->getUser();

        $hotel = $owner->getIdHotel();

        if (!$hotel) {
            $this->addFlash('error', 'Aucun hôtel associé à ce compte.');
            return $this->redirectToRoute('app_user_profil');
        }

        return $this->render('admin/owner/owner_hotel_information.html.twig', [
            'hotel' => $hotel,
        ]);
    }

    #[IsGranted('ROLE_OWNER')]
    #[Route('/admin/mon-hotel/edit', name: 'owner_hotel_edit')]
    public function editOwnerHotel(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        /** @var User $owner */
        $owner = $this->getUser();
        $hotel = $owner->getIdHotel();

        if (!$hotel) {
            $this->addFlash('error', 'Aucun hôtel associé à ce compte.');
            return $this->redirectToRoute('app_user_profil');
        }

        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hotel->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->flush();

            $this->addFlash('success', 'Votre hôtel a bien été mis à jour.');
            return $this->redirectToRoute('owner_hotel');
        }

        return $this->render('admin/owner/owner_hotel_information_edit.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route('/profil', name: 'app_user_profil', methods: ['GET', 'POST'])]
    public function profil(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $form = $this->createForm(ClientProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPassword = $form->get('password')->getData();

            if ($newPassword) {
                $hashedPassword = $hasher->hashPassword($user, $newPassword);
                $user->setPassword($hashedPassword);
            }

            $user->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->flush();

            $this->addFlash('success', 'Profil mis à jour avec succès.');

            return $this->redirectToRoute('app_user_profil');
        }



        return $this->render('client/client_profil.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/profil/delete', name: 'app_user_delete_account', methods: ['POST'])]
    public function deleteAccount(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if ($this->isCsrfTokenValid('delete_account', $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_logout');
        }

        return $this->redirectToRoute('app_user_profil');
    }

}
