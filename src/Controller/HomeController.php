<?php

namespace App\Controller;

use App\Entity\Reservations;
use App\Form\ReservationType;
use App\Repository\PlatsRepository;
use App\Repository\ReservationsRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PlatsRepository $platsRepository): Response
    {

        $plats = $platsRepository->findAll();
        $reservation = new Reservations();
        $form = $this->createForm(ReservationType::class, $reservation);


        return $this->render('home/index.html.twig', [
            'plat' => $plats,
            'form' => $form->createView()
        ]);
    }


}
