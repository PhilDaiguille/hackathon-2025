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

#[Route('/admin/offer')]
final class OfferController extends AbstractController
{
    public function __construct(
        private MapService $mapService
    )
    {
    }
    #[Route(name: 'app_offer_index', methods: ['GET'])]
    public function index(OfferRepository $offerRepository): Response
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

    #[Route('/new', name: 'app_offer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $offer = new Offer();
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
