<?php

namespace App\Controller;

use App\Repository\HorairesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HorairesController extends AbstractController
{

    // Action pour afficher les horaires
    #[Route('/horaires', name: 'app_horaires_afficherhoraires')]
    public function afficherHoraires(HorairesRepository $horairesRepository): Response
    {
        // Récupère et affiche les horaires en base de données
        $horaire = $horairesRepository->findAll();
        return $this->render('partials/footer.html.twig', [
            'horaires' => $horaire,
        ]);
    }
}
