<?php

namespace App\Controller;

use App\Repository\MenusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    //Action pour afficher les menus
    #[Route('/menu', name: 'app_menu')]
    public function index(MenusRepository $menusRepository): Response
    {
        // Récupère et affiche les menus en base de données
        $menu = $menusRepository->findAll();

        return $this->render('menu/index.html.twig', [
            'menus' => $menu,
        ]);
    }
}
