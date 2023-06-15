<?php

namespace App\Controller\Admin;

use App\Entity\Adopter;
use App\Entity\Announcer;
use App\Entity\Race;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

//  /!\ Decommenter pour permettre la sécurisation de la page
// #[IsGranted("ROLE_ADMIN")] 
class DashboardController extends AbstractDashboardController
{
    #[Route(path: '/admin', name: 'admin_dashboard_index')]
    public function index(): Response
    {
        return $this->render('Admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('WoofAdopte Admin')
            ->renderContentMaximized();
    }

    // CONFIGURATION GLOBALE DES PAGES CRUD 
    public function configureCrud(): Crud
    {
        return parent::configureCrud()
            ->showEntityActionsInlined()
            ->setPaginatorPageSize(30)
            ->setPaginatorRangeSize(3);

    }


    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Adoptants', 'fas fa-user', Adopter::class);
        yield MenuItem::linkToCrud('Annonceurs', 'fas fa-id-card', Announcer::class);
        yield MenuItem::linkToCrud('Races', 'fas fa-paw', Race::class);
    }

}