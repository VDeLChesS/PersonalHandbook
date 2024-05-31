<?php

namespace App\Controller\Crud;

use App\Entity\SuggestedTasks;
use App\Form\SuggestedTasksType;
use App\Repository\SuggestedTasksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tasks/suggested')]
class SuggestedTasksController extends AbstractController
{
    #[Route('/', name: 'suggested_tasks_index', methods: ['GET'])]
    public function index(SuggestedTasksRepository $suggestedTasksRepository): Response
    {
        return $this->render('suggested_tasks/index.html.twig', [
            'suggested_tasks' => $suggestedTasksRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'suggested_tasks_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $suggestedTask = new SuggestedTasks();
        $form = $this->createForm(SuggestedTasksType::class, $suggestedTask);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($suggestedTask);
            $entityManager->flush();

            return $this->redirectToRoute('suggested_tasks_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('suggested_tasks/new.html.twig', [
            'suggested_task' => $suggestedTask,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'suggested_tasks_show', methods: ['GET'])]
    public function show(SuggestedTasks $suggestedTask): Response
    {
        return $this->render('suggested_tasks/show.html.twig', [
            'suggested_task' => $suggestedTask,
        ]);
    }

    #[Route('/{id}/edit', name: 'suggested_tasks_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SuggestedTasks $suggestedTask, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SuggestedTasksType::class, $suggestedTask);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('suggested_tasks_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('suggested_tasks/edit.html.twig', [
            'suggested_task' => $suggestedTask,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'suggested_tasks_delete', methods: ['POST'])]
    public function delete(Request $request, SuggestedTasks $suggestedTask, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$suggestedTask->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($suggestedTask);
            $entityManager->flush();
        }

        return $this->redirectToRoute('suggested_tasks_index', [], Response::HTTP_SEE_OTHER);
    }
}
