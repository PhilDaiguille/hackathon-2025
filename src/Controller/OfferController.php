<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Form\OfferType;
use App\Repository\OfferRepository;
use App\Service\MapService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\SmartSearchService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Entity\User;
use App\Entity\Hotel;


#[Route('/admin/offer')]
final class OfferController extends AbstractController
{

    #[Route(name: 'app_offer_index', methods: ['GET'])]
    public function index(OfferRepository $offerRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if ($this->isGranted('ROLE_ADMIN')) {
            $offers = $offerRepository->findAll();
        } elseif ($this->isGranted('ROLE_OWNER')) {
            $hotel = $user->getIdHotel();
            if ($hotel) {
                $offers = $offerRepository->findBy(['idHotel' => $hotel]);
            } else {
                $this->addFlash('warning', "Aucun hôtel associé à votre compte.");
                $offers = [];
            }
        } else {
            throw $this->createAccessDeniedException('Vous n’avez pas accès à cette page.');
        }

        return $this->render('offer/index.html.twig', [
            'offers' => $offers,
        ]);
    }



    #[Route('/new', name: 'app_offer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $isAdmin = $this->isGranted('ROLE_ADMIN');
        $isOwner = $this->isGranted('ROLE_OWNER');

        $offer = new Offer();

        // Si propriétaire d’un hôtel, on fixe l’hôtel dès le départ
        if ($isOwner && $user->getIdHotel()) {
            $offer->setIdHotel($user->getIdHotel());
        }

        // On passe des options personnalisées au formulaire
        $form = $this->createForm(OfferType::class, $offer, [
            'is_admin' => $isAdmin,
            'user_hotel' => $user->getIdHotel(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sécurité supplémentaire : on force l’hôtel s’il est OWNER
            if ($isOwner && $user->getIdHotel()) {
                $offer->setIdHotel($user->getIdHotel());
            }

            $entityManager->persist($offer);
            $entityManager->flush();

            return $this->redirectToRoute('app_offer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offer/new.html.twig', [
            'offer' => $offer,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_offer_show', methods: ['GET'])]
    public function show(Offer $offer): Response
    {
        return $this->render('offer/show.html.twig', [
            'offer' => $offer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_offer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Offer $offer, EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $isAdmin = $this->isGranted('ROLE_ADMIN');
        $isOwner = $this->isGranted('ROLE_OWNER');

        // Protection : si OWNER mais pas le bon hôtel → accès interdit
        if ($isOwner && $offer->getIdHotel() !== $user->getIdHotel()) {
            throw $this->createAccessDeniedException("Vous ne pouvez modifier que les offres de votre propre hôtel.");
        }

        // Formulaire avec options adaptées
        $form = $this->createForm(OfferType::class, $offer, [
            'is_admin' => $isAdmin,
            'user_hotel' => $user->getIdHotel(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sécurité supplémentaire : forcer l’hôtel si OWNER
            if ($isOwner && $user->getIdHotel()) {
                $offer->setIdHotel($user->getIdHotel());
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_offer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offer/edit.html.twig', [
            'offer' => $offer,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_offer_delete', methods: ['POST'])]
    public function delete(Request $request, Offer $offer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offer->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($offer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_offer_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/offer/search', name: 'app_offer_search', methods: ['GET'])]
    public function search(Request $request, SmartSearchService $smartSearchService, OfferRepository $offerRepository): Response
    {
        $query = $request->query->get('query', '');
        $criteria = $smartSearchService->parseQuery($query);

        $offers = $offerRepository->findBySmartCriteria($criteria);

        return $this->render('offer/index.html.twig', [
            'offers' => $offers,
            'query' => $query,
        ]);
    }
}
