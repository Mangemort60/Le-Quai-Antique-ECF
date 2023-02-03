<?php

namespace App\Controller\Admin;

use App\Entity\Horaires;
use App\Entity\Menus;
use App\Entity\Carte;
use App\Entity\PlacesMax;
use App\Entity\Reservations;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use PhpParser\Node\Expr\Yield_;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Mon tableau de bord');

    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-dashboard');
        yield MenuItem::linkToCrud('Carte', 'fas fa-list', Carte::class);
        Yield MenuItem::linkToCrud('Horaires', 'fas fa-clock', Horaires::class);
        Yield MenuItem::linkToCrud('Menus', 'fas fa-utensils', Menus::class);
        Yield MenuItem::linkToCrud('Reservation', 'fas fa-list', Reservations::class);
        Yield MenuItem::linkToCrud('PlacesMax', 'fa-solid fa-chair', PlacesMax::class);

    }
}
