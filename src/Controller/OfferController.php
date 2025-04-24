<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\MapService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OfferController extends AbstractController
{
    public function __construct(
    )
    {
    }
    #[Route('/offers')]
    public function index(): Response
    {


        return $this->render('client/home_client/index.html.twig',[

        ]);
    }
}
