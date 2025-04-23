<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\MapService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private MapService $mapService
    )
    {
    }
    #[Route('/')]
    public function index(): Response
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

        return $this->render('home/index.html.twig',[
            'map' => $map,
        ]);
    }
}
