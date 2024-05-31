<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Addresses;
use App\Entity\Tasks;
use App\Entity\Appointments;
use App\Entity\SuggestedTasks;
use App\Entity\Events;
use App\Form\UserType;
use App\Repository\ProjectsRepository;
use App\Repository\AddressesRepository;
use App\Repository\AppointmentsRepository;
use App\Repository\TasksRepository;
use App\Repository\MyNotesRepository;
use App\Repository\SuggestedTasksRepository;
use App\Repository\UserRepository;
use App\Repository\EventsRepository;
use App\Form\AddressesType;
use App\Form\SuggestedTasksType;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\Time;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\UX\Turbo\TurboBundle;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Util\TargetPathTrait;



#[Route('/user')]
#[IsGranted('ROLE_USER')]
class UserAccessController extends AbstractController
{
    #[Route('/', name: 'app_user_access')]
    public function index(SuggestedTasksRepository $suggestedTasksRepository): Response
    {
        $user = $this->getUser();
        $suggestedTasks = $suggestedTasksRepository->findAll();
        return $this->render('user_access/index.html.twig', [
            'controller_name' => 'UserAccessController',
            'user' => $user,
            'suggestedTasks' => $suggestedTasks
        ]);
    }

    #[Route('/profile', name: 'app_user_profile')]
    public function profile(#[CurrentUser] User $user, AddressesRepository $addressesRepo, TasksRepository $tasksRepo, MyNotesRepository $myNotesRepo, ProjectsRepository $projectsRepo): Response
    {
        $user = $this->getUser();
        $userAddresses = $addressesRepo->findBy(['user' => $user, 'is_current' => true]);
        $userTasks = $tasksRepo->findBy(['user' => $user]);
        $userMyNotes = $myNotesRepo->findBy(['user' => $user]);
        $userProjects = $projectsRepo->findBy(['user' => $user]);
        return $this->render('user_access/profile.html.twig', [
            'controller_name' => 'UserAccessController', 
            'user' => $user,
            'addresses' => $userAddresses,
            'tasks' => $userTasks,
            'myNotes' => $userMyNotes,
            'projects' => $userProjects
        ]);
    }

    #[Route('/profile/edit', name: 'app_profile_edit', methods: ['GET', 'POST'])]
    public function edit_profile(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_user_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_access/edit_profile.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/calendar', name: 'app_user_calendar')]
    public function calendar(#[CurrentUser] User $user, TasksRepository $tasksRepo, AppointmentsRepository $appointmentsRepo, EventsRepository $eventsRepo): Response
    {
        $user = $this->getUser();
        $currentDate = new \DateTime();
        $tasks = $tasksRepo->findBy(['user' => $user], ['due_date' => 'DESC']);
        $tasks = array_filter($tasks, function ($task) {
            return $task->getDueDate() >= new Date();
        });
        $tasks = array_filter($tasks, function ($task) {
            return $task->getDueTime() <= new Time();
        });
        $tasks = array_values($tasks);
        $appointments = $appointmentsRepo->findBy(['user' => $user], ['date' => 'DESC']);
        $appointments = array_filter($appointments, function ($appointment) {
            return $appointment->getDate() >= new Date();
        });
        $appointments = array_filter($appointments, function ($appointment) {
            return $appointment->getTime() <= new Time();
        });
        $appointments = array_values($appointments);
        $events = $eventsRepo->findBy(['user' => $user], ['start_datetime' => 'DESC']);
        $events = array_filter($events, function ($event) {
            return $event->getStartDatetime() >= new DateTime();
        });
        $events = array_filter($events, function ($event) {
            return $event->getEndDatetime() <= new DateTime();
        });
        $events = array_values($events);

        return $this->render('user_access/calendar.html.twig', [
            'controller_name' => 'UserAccessController',
            'user' => $user,
            'tasks' => $tasks,
            'appointments' => $appointments,
            'events' => $events,
            'currentDate' => $currentDate
        ]);
    }

    #[Route('/addresses', name: 'app_addresses_index', methods: ['GET'])]
    public function user_addresses(AddressesRepository $addressesRepository, #[CurrentUser] User $user): Response
    {
        $user = $this->getUser();
        $userAddresses = $addressesRepository->findBy(['user' => $user]);
        return $this->render('user_access/addresses/index.html.twig', [
            'addresses' => $userAddresses,
            'user' => $user,
        ]);
    }

    #[Route('/addresses/new', name: 'app_addresses_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, #[CurrentUser] User $user): Response
    {
        $user = $this->getUser();
        $address = new Addresses();
        $address->setUser($user);
        $form = $this->createForm(AddressesType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($address);
            $entityManager->flush();

            return $this->redirectToRoute('app_addresses_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_access/addresses/new.html.twig', [
            'address' => $address,
            'form' => $form,
        ]);
    }

    #[Route('/addresses/{id}', name: 'app_addresses_show', methods: ['GET'])]
    public function show(Addresses $address): Response
    {
        return $this->render('user_access/addresses/show.html.twig', [
            'address' => $address,
        ]);
    }

    #[Route('/addresses/{id}/edit', name: 'app_addresses_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Addresses $address, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AddressesType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_addresses_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_access/addresses/edit.html.twig', [
            'address' => $address,
            'form' => $form,
        ]);
    }

    #[Route('/addresses/{id}', name: 'app_addresses_delete', methods: ['POST'])]
    public function delete(Request $request, Addresses $address, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$address->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($address);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_addresses_index', [], Response::HTTP_SEE_OTHER);
    }
}
