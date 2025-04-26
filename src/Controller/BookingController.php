<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Enum\BookingStatus;
use App\Enum\NegotiationStatus;
use App\Entity\Negociation;


#[Route('/admin/booking')]
final class BookingController extends AbstractController
{
    #[Route(name: 'app_booking_index', methods: ['GET'])]
    public function index(BookingRepository $bookingRepository): Response
    {
        return $this->render('booking/index.html.twig', [
            'bookings' => $bookingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_booking_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $now = new \DateTimeImmutable();
            $booking->setCreatedAt($now);
            $booking->setUpdatedAt($now);

            $offer = $booking->getIdOffer();
            $room = $offer->getIdRoom();
            $basePrice = $room->getBasePrice();
            $finalPrice = $booking->getFinalPrice();

            $acceptThreshold = $offer->getAcceptanceThreshold();
            $refuseThreshold = $offer->getRefusalThreshold();

            $priceAccept = $basePrice * ($acceptThreshold / 100);
            $priceRefuse = $basePrice * ($refuseThreshold / 100);

            if ($finalPrice >= $priceAccept) {
                $booking->setStatus(BookingStatus::ACCEPTED);

                foreach ($offer->getBookings() as $other) {
                    if ($other !== $booking) {
                        $other->setStatus(BookingStatus::REFUSED);
                        $em->persist($other);
                    }
                }

                $offer->setBooking($booking);

            } elseif ($finalPrice <= $priceRefuse) {

                $booking->setStatus(BookingStatus::REFUSED);
            } else {
                $booking->setStatus(BookingStatus::PENDING);

                $negociation = new Negociation();
                $negociation->setIdBooking($booking);
                $negociation->setNewPrice($finalPrice);
                $negociation->setStatus(NegotiationStatus::PENDING);
                $negociation->setCreatedAt($now);
                $negociation->setUpdatedAt($now);
                $negociation->setResponseDeadline((new \DateTime())->modify('+3 hours'));

                $em->persist($negociation);
            }

            $em->persist($booking);
            $em->flush();

            return $this->redirectToRoute('app_booking_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('booking/new.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_booking_show', methods: ['GET'])]
    public function show(Booking $booking): Response
    {
        return $this->render('booking/show.html.twig', [
            'booking' => $booking,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_booking_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Booking $booking, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_booking_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_booking_delete', methods: ['POST'])]
    public function delete(Request $request, Booking $booking, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($booking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_booking_index', [], Response::HTTP_SEE_OTHER);
    }
}
