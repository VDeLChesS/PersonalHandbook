<?php

namespace App\Controller\Crud;

use App\Entity\Tasks;
use App\Form\TasksType;
use App\Entity\User;
use App\Entity\Categories;
use App\Entity\Status;
use App\Repository\StatusRepository;
use App\Repository\CategoriesRepository;
use App\Service\FileUploader;
use App\Repository\UserRepository;
use App\Repository\TasksRepository;
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

#[Route('user/tasks')]
#[Broadcast]
#[IsGranted('ROLE_USER')]
class TasksController extends AbstractController
{
    #[Route('/', name: 'tasks_index', methods: ['GET'])]
    public function index(TasksRepository $tasksRepository, #[CurrentUser] User $user, Categories $category, Status $status): Response
    {
        $user = $this->getUser();
        $tasks_category = $tasksRepository->findBy(['category' => $category]);
        $tasks_status = $tasksRepository->findBy(['status' => $status]);
        $userTasks = $tasksRepository->findBy(['user' => $user], ['due_date' => 'DESC']);
        return $this->render('tasks/index.html.twig', [
            'tasks' => $userTasks,
            'user' => $user,
            'category' => $tasks_category,
            'status' => $tasks_status,
        ]);
    }

    #[Route('/new', name: 'tasks_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, #[CurrentUser] User $user, StatusRepository $statusRepository, CategoriesRepository $categoryRepository): Response
    {
        $user = $this->getUser();
        $status = $statusRepository->findOneBy(['name' => 'Pending']);
        $category = $categoryRepository->findOneBy(['name' => 'Personal']);
            if (!$user) {
                throw new AccessDeniedException('You need to be logged in to create a task.');
            }

        $task = new Tasks();
        $task->setUser($user);
        $form = $this->createForm(TasksType::class, $task);
        $form->handleRequest($request);
        $currentDate = new DateTimeImmutable('now');

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('picture')->getData();
            if ($picture) {
                $pictureName = $fileUploader->upload($task);
                $task->setpicture($pictureName);
            } else {
                $task->setPicture("default.jpg");
            }
            $task->setCategory($category);
            $task->setCreatedAt($currentDate);
            $task->setUpdatedAt($currentDate);
            $task->setStatus($status);
            $task = $form->getData();
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('tasks_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tasks/new.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'tasks_show', methods: ['GET'])]
    public function show(Tasks $task): Response
    {
        return $this->render('tasks/show.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route('/{id}/edit', name: 'tasks_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tasks $task, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TasksType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('picture')->getData();
            if ($picture) {
                if($task->getPicture() != 'default.jpg') {
                    unlink($this->getParameter('picture_directory') . '/' . $task->getPicture());
                }
                $pictureName = $fileUploader->upload($picture);
                $task->setpicture($pictureName);
            }
            $entityManager->flush();

            return $this->redirectToRoute('tasks_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tasks/edit.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'tasks_delete', methods: ['POST'])]
    public function delete(Request $request, Tasks $task, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->getPayload()->get('_token'))) {
            if($task->getPicture() != 'default.jpg') {
                unlink($this->getParameter('picture_directory') . '/' . $task->getPicture());
              }
            $entityManager->remove($task);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tasks_index', [], Response::HTTP_SEE_OTHER);
    }
}
