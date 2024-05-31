<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use App\Entity\User;
use App\Entity\Addresses;
use App\Entity\Projects;
use App\Entity\Tasks;
use App\Entity\Events;
use App\Entity\Appointments;
use App\Entity\MyNotes;
use App\Entity\DailySchedules;
use App\Entity\SuggestedTasks;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    private $chartBuilder;

    public function __construct(ChartBuilderInterface $chartBuilder)
    {
        $this->chartBuilder = $chartBuilder;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);
        return $this->render('admin/dashboard.html.twig', [
            'chart' => $chart,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="https://cdn.iconscout.com/icon/free/png-256/free-avatar-370-456322.png">Task Manager App')

            ->setFaviconPath('https://cdn.iconscout.com/icon/free/png-256/free-avatar-370-456322.png')

            ->setTranslationDomain('admin')

            ->setTextDirection('ltr')
            

            ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Dashboard');
        yield MenuItem::linkToDashboard('Dashboard', 'fa-solid fa-user-tie');
        yield MenuItem::linkToRoute('Back to the website', 'fas fa-home', 'home');
        yield MenuItem::linkToRoute('Profile', 'fa-solid fa-id-badge', 'app_user_profile');
        yield MenuItem::linkToRoute('Calendar', 'fa-regular fa-calendar-days', 'app_user_calendar');
        
        yield MenuItem::section('Useful Links');
        yield MenuItem::linkToUrl('Database', 'fa-solid fa-database', 'http://localhost/phpmyadmin/index.php?route=/database/structure&db=fullstackproject_taskmanager');
        yield MenuItem::linkToUrl('EasyAdmin Docs', 'fas fa-book', 'https://symfony.com/doc/current/bundles/EasyAdminBundle/index.html');
        yield MenuItem::linkToUrl('Search in Google', 'fab fa-google', 'https://google.com');
        
        
        yield MenuItem::section('Entities');
        yield MenuItem::linkToCrud('User', 'fa-solid fa-users', User::class);
        yield MenuItem::linkToCrud('Addresses', 'fa-solid fa-address-book', Addresses::class);
        yield MenuItem::linkToCrud('Projects', 'fa-solid fa-project-diagram', Projects::class);
        yield MenuItem::linkToCrud('Tasks', 'fa-solid fa-tasks', Tasks::class);
        yield MenuItem::linkToCrud('Appointments', 'fa-solid fa-calendar-alt', Appointments::class);
        yield MenuItem::linkToCrud('Events', 'fa-solid fa-champagne-glasses', Events::class);
        yield MenuItem::linkToCrud('Notes', 'fa-solid fa-sticky-note', MyNotes::class);
        yield MenuItem::linkToCrud('Daily Schedules', 'fa-solid fa-table-list', DailySchedules::class);
        yield MenuItem::linkToCrud('SuggestedTasks', 'fa-solid fa-tasks', SuggestedTasks::class);

        yield MenuItem::section('Settings');
        yield MenuItem::linkToLogout('Logout', 'fa-solid fa-right-from-bracket');
        
    }
}
