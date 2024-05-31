<?php

namespace App\Controller;


use Symfony\Component\DependencyInjection\StaticViewInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
class StaticViewController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('static_view/index.html.twig', [
            'controller_name' => 'StaticViewController',
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('static_view/about.html.twig', [
            'controller_name' => 'StaticViewController',
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('static_view/contact.html.twig', [
            'controller_name' => 'StaticViewController',
        ]);
    }

    #[Route('/privacy', name: 'app_privacy')]
    public function privacy(): Response
    {
        return $this->render('static_view/privacy.php', [
            'controller_name' => 'StaticViewController',
        ]);
    }
}
