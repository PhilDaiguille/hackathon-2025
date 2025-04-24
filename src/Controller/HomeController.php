<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\OfferRepository;
use App\Service\MapService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home_index')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }
    public function __construct(
        private MapService $mapService
    )
    {
    }
    #[Route('/offer',name: 'app_offer_client', methods: ['GET'])]
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

        return $this->render('client/home_client/index.html.twig', [
            'offers' => $offerRepository->findAll(),
            'map' => $map,
        ]);
    }
}
