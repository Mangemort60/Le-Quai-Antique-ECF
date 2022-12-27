<?php

namespace App\Controller;

use App\Repository\MenusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    #[Route('/menu', name: 'app_menu')]
    public function index(MenusRepository $menusRepository): Response
    {
        $menu = $menusRepository->findAll();

        return $this->render('menu/index.html.twig', [
            'menus' => $menu,
        ]);
    }
}
