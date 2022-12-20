<?php

namespace App\Controller;

use App\Repository\CarteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarteController extends AbstractController
{
    #[Route('/carte', name: 'app_carte')]
    public function index(CarteRepository $carteRepository): Response
    {
        $plat = $carteRepository->findAll();
        return $this->render('carte/index.html.twig', [
            'plats' => $plat,
        ]);
    }
}
