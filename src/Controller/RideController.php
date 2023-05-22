<?php

namespace App\Controller;

use App\Entity\Ride;
use App\Form\RideType;
use App\Repository\RideRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ride')]
class RideController extends AbstractController
{
    #[Route('/', name: 'app_ride_index', methods: ['GET'])]
    public function index(RideRepository $rideRepository): Response
    {
        return $this->render('ride/index.html.twig', [
            'rides' => $rideRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ride_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RideRepository $rideRepository): Response
    {
        $ride = new Ride();
        $form = $this->createForm(RideType::class, $ride);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rideRepository->save($ride, true);

            return $this->redirectToRoute('app_ride_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ride/new.html.twig', [
            'ride' => $ride,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ride_show', methods: ['GET'])]
    public function show(Ride $ride): Response
    {
        return $this->render('ride/show.html.twig', [
            'ride' => $ride,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ride_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ride $ride, RideRepository $rideRepository): Response
    {
        $form = $this->createForm(RideType::class, $ride);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rideRepository->save($ride, true);

            return $this->redirectToRoute('app_ride_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ride/edit.html.twig', [
            'ride' => $ride,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ride_delete', methods: ['POST'])]
    public function delete(Request $request, Ride $ride, RideRepository $rideRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ride->getId(), $request->request->get('_token'))) {
            $rideRepository->remove($ride, true);
        }

        return $this->redirectToRoute('app_ride_index', [], Response::HTTP_SEE_OTHER);
    }
}
