<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\OfferRepository;
use App\Service\MapService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController
{
    public function __construct(
        private MapService $mapService
    )
    {
    }

    #[Route('/offer', name: 'app_offer_client', methods: ['GET'])]
    public function offer(OfferRepository $offerRepository): Response
    {
        $map = $this->mapService->createDefaultMap();

        $this->mapService->addMarkers($map, [
            [
                'lat' => 45.7534031,
                'lng' => 4.8295061,
                'title' => 'Lyon',
                'content' => '<p>Thank you <a href="https://github.com/Kocal">@Kocal</a> for this component!</p>'
            ],
            [
                'lat' => 42.7534031,
                'lng' => 6.8295061,
                'title' => 'Lyon',
                'content' => '<p>Thank you <a href="https://github.com/Kocal">@Kocal</a> for this component!</p>'
            ],
            [
                'lat' => 44.7534031,
                'lng' => 5.8295061,
                'title' => 'Lyon',
                'content' => '<p>Thank you <a href="https://github.com/Kocal">@Kocal</a> for this component!</p>'
            ],
        ]);
        $offers = $offerRepository->findAll();
        $user = $this->getUser();
        $wishlists = $user ? $user->getWishlists() : [];

        $hotelIdsInWishlist = [];
        foreach ($wishlists as $wishlist) {
            $hotel = $wishlist->getHotel();
            if ($hotel) {
                $hotelIdsInWishlist[] = $hotel->getId();
            }
        }
        $offers = array_filter(
            $offerRepository->findAll(),
            function ($offer) use ($hotelIdsInWishlist) {
                return !in_array($offer->getIdHotel()->getId(), $hotelIdsInWishlist, true);
            }
        );


        return $this->render('client/home_client/index.html.twig', [
            'offers' => $offers,
            'map' => $map,
        ]);
    }

    #[Route('/profile/reservation', name: 'app_offer_reservation_client', methods: ['GET'])]
    public function profile(): Response
    {
        $reservations = $this->getUser()->getBookings()->toArray();

        return $this->render('client/client_reservation.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    #[Route('/profile/wishlist', name: 'app_offer_wishlist_client', methods: ['GET'])]
    public function wishlist(): Response
    {
        $wishlists = $this->getUser()->getWishlists()->toArray();

        return $this->render('client/client_wishlist.html.twig', [
            'wishlists' => $wishlists,
        ]);
    }
}
