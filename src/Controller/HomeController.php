<?php

namespace App\Controller;

use App\Entity\Reservations;
use App\Form\ReservationType;
use App\Repository\CarteRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CarteRepository $carteRepository, Request $request,ManagerRegistry $managerRegistry): Response
    {
        $entityManager = $managerRegistry->getManager();

        $plat = $carteRepository->findAll();

        $reservation = new Reservations();

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $reservation = $form->getData();
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');

        }

        return $this->render('home/index.html.twig', [
            'plats' => $plat,
            'form' => $form->createView()
        ]);
    }




}
