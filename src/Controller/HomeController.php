<?php

namespace App\Controller;

use App\Entity\Reservations;
use App\Form\ReservationType;
use App\Repository\CarteRepository;
use App\Repository\PlacesMaxRepository;
use App\Repository\ReservationsRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CarteRepository $carteRepository,
                          Request $request,
                          ManagerRegistry $managerRegistry,
                          ReservationsRepository $reservationsRepository,
                          PlacesMaxRepository $placesMaxRepository  ): Response
    {

        $maxReservationPerDay = $placesMaxRepository->findOneBy(['id' => '1']);
        $maxReservationPerDayValue = $maxReservationPerDay->getNbrPlacesMax();

        $entityManager = $managerRegistry->getManager();
        $plat = $carteRepository->findAll();

        $reservation = new Reservations();
        $reservation->setDate(new \DateTime());
        
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        $data = $form->getData();
        $dateReservation = $data->getDate();
        $nbrCouvertSelectionne = $data->getnbrCouvert();

        $dateReservation = $dateReservation->format('Y-m-d');
        $nbrCouvertParJour = $reservationsRepository->countNbrCouvertForDate($dateReservation);

        if ($form->isSubmitted() && $form->isValid() && $maxReservationPerDayValue >= ($nbrCouvertParJour + $nbrCouvertSelectionne)) {
            $entityManager->persist($reservation);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        } else {
            $this->addFlash('full', 'Il n\'ya plus de place disponible à cette date');
            $this->redirectToRoute('app_home');
        }


        return $this->render('home/index.html.twig', [
            'plats' => $plat,
            'form' => $form->createView()
        ]);
    }




}
