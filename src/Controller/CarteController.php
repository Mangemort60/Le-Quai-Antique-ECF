<?php

namespace App\Controller;

use App\Repository\CarteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarteController extends AbstractController
{

    // Action pour afficher entrées, plats, desserts
    #[Route('/carte', name: 'app_carte')]
    public function index(CarteRepository $carteRepository): Response
    {
        // Récupération tout le contenu de la table carte en base de données
        $plats = $carteRepository->findAll();
        // Affiche la vue Twig avec le contenu de la table carte
        return $this->render('carte/index.html.twig', [
            'plats' => $plats,
        ]);
    }
}
