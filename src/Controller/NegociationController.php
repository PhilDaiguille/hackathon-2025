<?php

namespace App\Controller;

use App\Entity\Negociation;
use App\Enum\BookingStatus;
use App\Enum\NegotiationStatus;
use App\Repository\NegociationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/negotiation')]
class NegociationController extends AbstractController
{
    #[Route('/', name: 'app_negotiation_index')]
    public function index(NegociationRepository $negociationRepository): Response
    {
        $negociations = $negociationRepository->findBy(['status' => NegotiationStatus::PENDING]);

        return $this->render('negotiation/index.html.twig', [
            'negociations' => $negociations,
        ]);
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
        return $this->redirectToRoute('app_negotiation_index');
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
        return $this->redirectToRoute('app_negotiation_index');
    }
}

