<?php

namespace App\Controller;

use App\Entity\Reservations;
use App\Form\ReservationType;
use App\Repository\CarteRepository;
use App\Repository\PlacesMaxRepository;
use App\Repository\ReservationsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\RequestStack;

class HomeController extends AbstractController
{
    // Fonction pour vérifier s'il y a un utilisateur connecté, ou s'il s'agit seulement d'un visiteur.
    private function getUserOrGuestIdentifier(Security $security): string
    {
        if ($security->getUser() !== null) {
            // si utilisateur connecté, retourne son email
            return $security->getUser()->getUserIdentifier();
        } else {
            // si pas d'utilisateur connecté, retourne 'visiteur'
            return 'visiteur';
        }
    }

    // Action pour afficher les produits favoris de la carte + un formulaire de reservation en modal sur la même page.
    #[Route('/', name: 'app_home')]
    public function index(CarteRepository $carteRepository,
                          Request $request, // Récupère les données du formulaire
                          ManagerRegistry $managerRegistry, // Gestion des entités
                          ReservationsRepository $reservationsRepository,
                          PlacesMaxRepository $placesMaxRepository,
                          Security $security, // Récupère l'utilisateur connecté
    ): Response
    {
        // Récupère le gestionnaire d'entité
        $entityManager = $managerRegistry->getManager();


        // Récupère le nombre de couverts maximum fixé en base de données dans la table PlacesMax
        $maxReservationPerDay = $placesMaxRepository->findOneBy(['id' => '1']); // Méthode pour récupérer l'unique ligne de la table.
        $maxReservationPerDayValue = $maxReservationPerDay->getNbrPlacesMax(); // récupère la valeur nbrPlacesMax

        // Récupère toutes les données de la table carte en base de données
        $plat = $carteRepository->findAll();

        // Création d'une nouvelle instance de l'entité Reservations
        $reservation = new Reservations();
        $reservation->setDate(new \DateTime()); // Permet de mettre une date par défaut au formulaire de réservation
        $reservation->setHeure(new \DateTime());// Permet de mettre une heure par défaut au formulaire de réservation

        // Récupère l'information enregistrée par défaut (Nombre de convives/allergies) par l'utilisateur connecté lors de son inscription
        if($this->isGranted('IS_AUTHENTICATED_FULLY') || $this->isGranted('ROLE_ADMIN')){
            $user = $security->getUser();
            $allergieUser = $user->getAllergies();
            $nbrCouvertUser = $user->getNbrConvive();
            $reservation->setNbrCouvert(intval($nbrCouvertUser)); // setNbrCouvert demande un integer, mais si la valeur est null pour l'utilisateur alors cela déclenche une erreur, j'ai donc utilisé la methode intval()
            $reservation->setAllergie($allergieUser);
        }



        // Création du formulaire et liaison avec l'entité correspondante
        $form = $this->createForm(ReservationType::class, $reservation);

        // Recuperation des données du formulaire
        $form->handleRequest($request);
        $data = $form->getData();
        $reservationDate = $data->getDate();
        $reservationHeure = $data->getHeure();
        $nbrCouvertSelectionne = $data->getnbrCouvert();


        // Formatage de la date et l'heure pour qu'elle puisse être passée au custom QueryBuilder countNbrCouvertForDate()
        $reservationDate = $reservationDate->format('Y-m-d');
        $reservationHeure = $reservationHeure->format('H:m:s');

        // Recuperation du nombre de couverts à une date sélectionnée pour le service du midi
        $nbrCouvertMidi = $reservationsRepository->countNbrCouvertDateMidi($reservationDate, $reservationHeure );

        // Recuperation du nombre de couverts à une date sélectionnée pour le service du soir
        $nbrCouvertSoir = $reservationsRepository->countNbrCouvertDateSoir($reservationDate, $reservationHeure);


        // Vérifie si formulaire valide, et si assez de place à la date et l'heure sélectionnée
        if ($form->isSubmitted()
            && $form->isValid()
            && ($maxReservationPerDayValue - $nbrCouvertMidi) >= $nbrCouvertSelectionne
            && ($maxReservationPerDayValue - $nbrCouvertSoir) >= $nbrCouvertSelectionne)
        {
            // Recuperation de l'email du client
            $mailUser = $this->getUserOrGuestIdentifier($security);
            $reservation->setClientEmail($mailUser);

            // Enregistrement en base de données et affichage d'un message de confirmation
            $entityManager->persist($reservation);
            $entityManager->flush();
            $this->addFlash('successMessage', 'Merci, votre réservation a bien été prise en compte');
            return $this->redirectToRoute('app_home');
        }
        // Sinon affiche un message d'erreur.
        if (($maxReservationPerDayValue - $nbrCouvertMidi) < $nbrCouvertSelectionne
    || ($maxReservationPerDayValue - $nbrCouvertSoir) < $nbrCouvertSelectionne ) {

            $this->addFlash('full', 'Il n\'y a plus de place disponible à cette date');
            return $this->redirectToRoute('app_home');
        }

        // On retourne le rendu twig auquel on passe les produits de la carte et le formulaire
        return $this->render('home/index.html.twig', [
            'plats' => $plat,
            'form' => $form->createView()
        ]);
    }




}


