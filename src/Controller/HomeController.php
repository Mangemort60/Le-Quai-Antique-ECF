<?php

namespace App\Controller;

use App\Entity\Reservations;
use App\Form\ReservationType;

use App\Repository\CarteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CarteRepository $carteRepository): Response
    {

        $plat = $carteRepository->findAll();
        $reservation = new Reservations();
        $form = $this->createForm(ReservationType::class, $reservation);

        return $this->render('home/index.html.twig', [
            'plats' => $plat,
            'form' => $form->createView()
        ]);
    }


}
