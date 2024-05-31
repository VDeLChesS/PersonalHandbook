<?php

namespace App\Controller\Crud;

use App\Entity\MyNotes;
use App\Entity\User;
use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use App\Form\CategoriesType;
use App\Form\UserType;
use App\Form\MyNotesType;
use App\Service\FileUploader;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Repository\MyNotesRepository;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints\DateTime;
use Monolog\DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\UX\Turbo\TurboBundle;


#[Route('/user/mynotes')]
#[IsGranted('ROLE_USER')]
class MyNotesController extends AbstractController
{

    #[Route('/', name: 'my_notes_index', methods: ['GET'])]
    public function index(MyNotesRepository $myNotesRepository, #[CurrentUser] User $user, CategoriesRepository $categoriesRepo): Response
    {
        $user = $this->getUser();
        $myNotes = $myNotesRepository->findBy(['user' => $user], ['category' => 'ASC']);
        $categories = $categoriesRepo->findAll();
        return $this->render('my_notes/index.html.twig', [
            'my_notes' => $myNotes,
            'user' => $user,
            'categories' => $categories,
        ]);
    }

    #[Route('/{category}', name: 'my_notes_category', methods: ['GET'])]
    public function category(MyNotesRepository $myNotesRepository, #[CurrentUser] User $user, Categories $category, CategoriesRepository $categoriesRepo): Response
    {
        $user = $this->getUser();
        $categories = $categoriesRepo->findAll();
        $myNotes = $myNotesRepository->findBy(['user' => $user, 'category' => $category]);
        return $this->render('my_notes/index.html.twig', [
            'my_notes' => $myNotes,
            'user' => $user,
            'categories' => $categories,
        ]);
    }

    #[Route('/new', name: 'my_notes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, #[CurrentUser] User $user, Categories $category, FileUploader $fileUploader): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw new AccessDeniedException('You need to be logged in to create a task.');
        }

        $myNote = new MyNotes();
        $myNote->setUser($user);
        $form = $this->createForm(MyNotesType::class, $myNote);
        $form->handleRequest($request);
        $currentDate = new DateTimeImmutable('now');

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $pictureFile */
            $picture = $form->get('picture')->getData();
            if ($picture) {
                $pictureName = $fileUploader->upload($picture);
                $myNote->setpicture($pictureName);
            } else {
                $myNote->setPicture("blog-2.jpg");
            }
            $myNote->setCreatedAt($currentDate);
            $myNote = $form->getData();
            $entityManager->persist($myNote);
            $entityManager->flush();

            return $this->redirectToRoute('my_notes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('my_notes/new.html.twig', [
            'my_note' => $myNote,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'my_notes_show', methods: ['GET'])]
    public function show(MyNotes $myNote, Categories $category): Response
    {
        return $this->render('my_notes/show.html.twig', [
            'my_note' => $myNote,
            'category' => $category,
        ]);
    }

    #[Route('/{id}/edit', name: 'my_notes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MyNotes $myNote, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(MyNotesType::class, $myNote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('picture')->getData();
            if ($picture) {
                if($myNote->getPicture() != 'blog-2.jpg') {
                    unlink($this->getParameter('picture_directory') . '/' . $myNote->getPicture());
                }
                $pictureName = $fileUploader->upload($picture);
                $myNote->setpicture($pictureName);
            }
            $myNote = $form->getData();
            $entityManager->flush();

            return $this->redirectToRoute('my_notes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('my_notes/edit.html.twig', [
            'my_note' => $myNote,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'my_notes_delete', methods: ['POST'])]
    public function delete(Request $request, MyNotes $myNote, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$myNote->getId(), $request->getPayload()->get('_token'))) {
            if($myNote->getPicture() != 'blog-2.jpg') {
                unlink($this->getParameter('picture_directory') . '/' . $myNote->getPicture());
            }
            $entityManager->remove($myNote);
            $entityManager->flush();
        }

        return $this->redirectToRoute('my_notes_index', [], Response::HTTP_SEE_OTHER);
    }
}
