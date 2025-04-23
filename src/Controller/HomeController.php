<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\HotelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/api/search-hotels', name: 'api_search_hotels', methods: ['POST'])]
    public function searchHotels(Request $request, HotelRepository $hotelRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $type = $data['type'] ?? null;
        $location = $data['location'] ?? null;
        $equipment = $data['equipment'] ?? [];

        $hotels = $hotelRepository->findAll();

        $filtered = array_filter($hotels, function ($hotel) use ($type, $location, $equipment) {
            if ($type && !str_contains(strtolower($hotel->getName()), strtolower($type))) return false;
            if ($location && strtolower($hotel->getCity()) !== strtolower($location)) return false;
            foreach ($equipment as $eq) {
                if (!in_array($eq, $hotel->getEquipment())) return false;
            }
            return true;
        });

        $response = array_map(fn($hotel) => [
            'name' => $hotel->getName(),
            'city' => $hotel->getCity(),
            'equipment' => $hotel->getEquipment(),
        ], $filtered);

        return new JsonResponse($response);
    }
}
