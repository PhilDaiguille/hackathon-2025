<?php

namespace App\Controller\Api;

use App\Entity\Hotel;
use App\Entity\Wishlist;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/wishlist', name: 'api_wishlist_', methods: ['POST'])]
class WishlistController extends AbstractController
{
    #[Route('', name: 'add')]
    public function add(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $user = $this->getUser();
        $hotelId = $request->request->get('hotel_id');

        if (!$user || !$hotelId) {
            return $this->json(['error' => 'Missing data'], 400);
        }

        $hotel = $em->getRepository(Hotel::class)->find($hotelId);
        if (!$hotel) {
            return $this->json(['error' => 'Hotel not found'], 404);
        }

        $existing = $em->getRepository(Wishlist::class)->findOneBy([
            'client' => $user,
            'hotel' => $hotel
        ]);

        if ($existing) {
            return $this->json(['message' => 'Already in wishlist']);
        }

        $wishlist = new Wishlist();
        $wishlist->setClient($user);
        $wishlist->setHotel($hotel);
        $wishlist->setCreatedAt(new \DateTimeImmutable());
        $em->persist($wishlist);
        $em->flush();

        return $this->json(['message' => 'Added to wishlist']);
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Wishlist $wishlist, EntityManagerInterface $em): RedirectResponse
    {
        if ($this->isCsrfTokenValid('delete' . $wishlist->getId(), $request->request->get('_token'))) {
            $em->remove($wishlist);
            $em->flush();
        }
        return $this->redirectToRoute('app_offer_wishlist_client');
    }
}
