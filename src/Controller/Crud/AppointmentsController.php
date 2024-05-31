<?php

namespace App\Controller\Crud;

use App\Entity\Appointments;
use App\Entity\User;
use App\Entity\Status;
use App\Form\AppointmentsType;
use App\Repository\UserRepository;
use App\Repository\AppointmentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Monolog\DateTimeImmutable;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\UX\Turbo\TurboBundle;

#[Route('/user/appointments')]
#[IsGranted('ROLE_USER')]
class AppointmentsController extends AbstractController
{
    #[Route('/', name: 'appointments_index', methods: ['GET'])]
    public function index(AppointmentsRepository $appointmentsRepository, #[CurrentUser] User $user): Response
    {
        $userAppointments = $appointmentsRepository->findBy(['user' => $user], ['created_at' => 'DESC']);
        return $this->render('appointments/index.html.twig', [
            'appointments' => $userAppointments,
        ]);
    }

    #[Route('/new', name: 'appointments_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, #[CurrentUser] User $user, Status $status): Response
    {
        $user = $this->getUser();

            if (!$user) {
                throw new AccessDeniedException('You need to be logged in to create a task.');
            }
        $myappointment = new Appointments();
        $myappointment->setUser($user);
        $form = $this->createForm(AppointmentsType::class, $myappointment);
        $form->handleRequest($request);
        $currentDate = new DateTimeImmutable('now');
        $status = $entityManager->getRepository(Status::class)->find(1);

        if ($form->isSubmitted() && $form->isValid()) {
            $myappointment->setCreatedAt($currentDate);
            $myappointment->setUpdatedAt($currentDate);
            $myappointment->setStatus($status);
            $myappointment = $form->getData();
            $entityManager->persist($myappointment);

            $entityManager->flush();
            
            return $this->redirectToRoute('appointments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('appointments/new.html.twig', [
            'appointment' => $myappointment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'appointments_show', methods: ['GET'])]
    public function show(Appointments $appointment): Response
    {
        return $this->render('appointments/show.html.twig', [
            'appointment' => $appointment,
        ]);
    }

    #[Route('/{id}/edit', name: 'appointments_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Appointments $appointment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AppointmentsType::class, $appointment);
        $form->handleRequest($request);
        $currentDate = new DateTimeImmutable('now');

        if ($form->isSubmitted() && $form->isValid()) {

            $appointment->setCreatedAt($currentDate);
            $appointment->setUpdatedAt(new DateTimeImmutable('now'));
            $entityManager->flush();

            return $this->redirectToRoute('appointments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('appointments/edit.html.twig', [
            'appointment' => $appointment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'appointments_delete', methods: ['POST'])]
    public function delete(Request $request, Appointments $appointment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$appointment->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($appointment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('appointments_index', [], Response::HTTP_SEE_OTHER);
    }
}
