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
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class HomeController extends AbstractController
{
    private function getUserOrGuestIdentifier(Security $security): string
    {
        if ($security->getUser() !== null) {
            // user connecté , retour identifiant
            return $security->getUser()->getUserIdentifier();
        } else {
            // user non connecté , retourne 'guest'
            return 'visiteur';
        }
    }

    #[Route('/', name: 'app_home')]
    public function index(CarteRepository $carteRepository,
                          Request $request,
                          ManagerRegistry $managerRegistry,
                          ReservationsRepository $reservationsRepository,
                          PlacesMaxRepository $placesMaxRepository,
                          Security $security,
    ): Response
    {
        // on va chercher l'entityManager qui va nous permettre de persister par la suite les données que l'on veut
        $entityManager = $managerRegistry->getManager();

        // on va chercher le nombre de couvert maximum fixé en base de données dans la table PlacesMax
        $maxReservationPerDay = $placesMaxRepository->findOneBy(['id' => '1']);
        $maxReservationPerDayValue = $maxReservationPerDay->getNbrPlacesMax();

        // on va chercher tout les plats dans la table Carte que l'on va parcourir avec une boucle for pour l'afficher dans twig.
        $plat = $carteRepository->findAll();

        // on créer une nouvelle instance de l'entité Reservations
        $reservation = new Reservations();
        $reservation->setDate(new \DateTime());

        // on récupère le user et ses infos allergie, et nombre de couvert
        if($this->isGranted('IS_AUTHENTICATED_FULLY') || $this->isGranted('ROLE_ADMIN')){
            $user = $security->getUser();
            $allergieUser = $user->getAllergies();
            $nbrCouvertUser = $user->getNbrConvive();
            $reservation->setNbrCouvert(intval($nbrCouvertUser)); // setNbrCouvert demande un integer, mais si la valeur est null pour le user alors cela declenche une erreur, j'ai donc utiliser la methode intval()
            $reservation->setAllergie($allergieUser);
        }



        // on crée le formulaire et on le reli à l'entité Reservation
        $form = $this->createForm(ReservationType::class, $reservation);

        // on récupère les données du formulaire
        $form->handleRequest($request);
        $data = $form->getData();

        // on récupère la date selectionnée dans le formulaire
        $dateReservation = $data->getDate();
        // on récupère le nombre de couvert dans le formulaire
        $nbrCouvertSelectionne = $data->getnbrCouvert();

        // on formate la date selectionné pour qu'elle puisse être acceptée dans la querybuilder que l'on a construite ci dessous
        $dateReservation = $dateReservation->format('Y-m-d');

        // on fait la somme de tout le couverts à une date donnée grâçe au queryBuilder countNbrCouvertForDate auquel on passe la date de reservation séléctionnée.
        $nbrCouvertParJour = $reservationsRepository->countNbrCouvertForDate($dateReservation);



        // on verifie is le formulaire est valide, si il est soumis, et si il y a assez de couvert disponible à la date selectionnée.
        if ($form->isSubmitted() && $form->isValid() && $maxReservationPerDayValue >= ($nbrCouvertParJour + $nbrCouvertSelectionne)) {
            // on récupère le mail du client
            $mailUser = $this->getUserOrGuestIdentifier($security);
            // on l'ajoute à la reservation
            $reservation->setClientEmail($mailUser);
            // on persist
            $entityManager->persist($reservation);
            $entityManager->flush();
            $this->addFlash('success', 'Merci, votre réservation a bien été prise en compte');
            return $this->redirectToRoute('app_home');
        }
        // sinon on affiche un message d'erreur.
        elseif ($maxReservationPerDayValue <= ($nbrCouvertParJour + $nbrCouvertSelectionne)) {
            $this->addFlash('full', 'Il n\'y a plus de place disponible à cette date');
            $this->redirectToRoute('app_home');
        }

        // on retourne le rendu du template twig auquel on passe les plats et le formulaire
        return $this->render('home/index.html.twig', [
            'plats' => $plat,
            'form' => $form->createView()
        ]);
    }




}
