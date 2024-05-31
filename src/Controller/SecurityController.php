<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class SecurityController extends AbstractController
{
    use TargetPathTrait;
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request, #[CurrentUser] ?User $user): Response
    {
        
        if ($this->getUser()) {
            if ($user->getRoles() == ["ROLE_ADMIN"]) {
                return $this->redirectToRoute('admin');
            }
            return $this->redirectToRoute('app_user_access');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($error) {
            $this->addFlash('error', 'Invalid credentials');
        }

        if ($user) {
            $this->addFlash('success', 'Welcome back ' . $user->getUsername());
        }

        if ($this->getUser()) {
            if ($user->getRoles() == ["ROLE_ADMIN"]) {
                $this->saveTargetPath($request->getSession(), 'main', $this->generateUrl('admin'));
            } else {
                $this->saveTargetPath($request->getSession(), 'main', $this->generateUrl('app_user_access'));
            }
        }
        

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
