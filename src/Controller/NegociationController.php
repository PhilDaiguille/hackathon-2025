<?php

namespace App\Controller;

use App\Entity\Negociation;
use App\Enum\BookingStatus;
use App\Enum\NegotiationStatus;
use App\Form\NegociationType;
use App\Repository\NegociationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;



#[Route('/admin/negociation')]
class NegociationController extends AbstractController
{
    #[Route(name: 'app_negociation_index', methods: ['GET'])]
    public function index(NegociationRepository $negociationRepository): Response
    {
        $negociations = $negociationRepository->findBy(['status' => NegotiationStatus::PENDING]);

        return $this->render('negociation/index.html.twig', [
            'negociations' => $negociations,
        ]);
    }

    #[Route('/new', name: 'app_negociation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $negociation = new Negociation();
        $form = $this->createForm(NegociationType::class, $negociation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($negociation);
            $entityManager->flush();

            return $this->redirectToRoute('app_negociation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('negociation/new.html.twig', [
            'negociation' => $negociation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_negociation_show', methods: ['GET'])]
    public function show(Negociation $negociation): Response
    {
        return $this->render('negociation/show.html.twig', [
            'negociation' => $negociation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_negociation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Negociation $negociation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NegociationType::class, $negociation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_negociation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('negociation/edit.html.twig', [
            'negociation' => $negociation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_negociation_delete', methods: ['POST'])]
    public function delete(Request $request, Negociation $negociation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$negociation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($negociation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_negociation_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/accept', name: 'app_negotiation_accept')]
    public function accept(Negociation $negociation, EntityManagerInterface $em): Response
    {
        $booking = $negociation->getIdBooking();
        $offer = $booking->getIdOffer();

        // Met à jour cette booking
        $booking->setStatus(BookingStatus::ACCEPTED);
        $offer->setBooking($booking);

        // Refuse toutes les autres bookings
        foreach ($offer->getBookings() as $otherBooking) {
            if ($otherBooking !== $booking) {
                $otherBooking->setStatus(BookingStatus::REFUSED);
                $em->persist($otherBooking);
            }
        }

        // Met à jour la négociation
        $negociation->setStatus(NegotiationStatus::ACCEPTED);
        $negociation->setUpdatedAt(new \DateTimeImmutable());

        $em->persist($negociation);
        $em->persist($booking);
        $em->persist($offer);
        $em->flush();

        $this->addFlash('success', 'Négociation acceptée.');
        return $this->redirectToRoute('app_negociation_index');
    }

    #[Route('/{id}/refuse', name: 'app_negotiation_refuse')]
    public function refuse(Negociation $negociation, EntityManagerInterface $em): Response
    {
        $booking = $negociation->getIdBooking();

        // Refuser cette booking
        $booking->setStatus(BookingStatus::REFUSED);

        // Refuser la négociation
        $negociation->setStatus(NegotiationStatus::REFUSED);
        $negociation->setUpdatedAt(new \DateTimeImmutable());

        $em->persist($booking);
        $em->persist($negociation);
        $em->flush();

        $this->addFlash('info', 'Négociation refusée.');
        return $this->redirectToRoute('app_negociation_index');
    }
}
