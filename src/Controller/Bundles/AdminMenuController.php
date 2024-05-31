<?php

namespace App\Controller\Bundles;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminMenuController extends AbstractController
{
    #[Route('/admin/menu', name: 'app_admin_menu')]
    public function index(): Response
    {
        return $this->render('admin_menu/index.html.twig', [
            'controller_name' => 'AdminMenuController',
        ]);
    }
}
