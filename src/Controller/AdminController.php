<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\ContactRepository;
use App\Repository\FigureRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'app_admin_')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'board')]
    public function index
    (
        UserRepository $userRepository,
        FigureRepository $figureRepository,
        CommentRepository $commentRepository,
        ContactRepository $contactRepository
    ): Response
    {
        $users = $userRepository->getUsersCount();
        $figures = $figureRepository->getFiguresCount();
        $comments = $commentRepository->getCommentsCount();
        $contacts = $contactRepository->getContactsCount();

        return $this->render('admin/index.html.twig', [
            'users' => $users,
            'figures' => $figures,
            'comments' => $comments,
            'contacts' => $contacts,
        ]);
    }

    #[Route('/users', name: 'users')]
    public function users(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('admin/users.html.twig', [
            'users' => $users,
        ]);
    }

    //A faire
    #[Route('/user/{id}', name: 'user_profile')]
    public function profile(UserRepository $userRepository): Response
    {
        $user = $userRepository->findBy('id');
        
        return $this->render('user/user_profile.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/figures', name: 'figures')]
    public function figures(FigureRepository $figureRepository): Response
    {
        $figures = $figureRepository->findBy(
            [],
            ['createdAt' => 'DESC']
        );

        return $this->render('admin/figures.html.twig', [
            'figures' => $figures,
        ]);
    }

    #[Route('/comments', name: 'comments')]
    public function comments(CommentRepository $commentRepository): Response
    {
        $comments = $commentRepository->findBy(
            [],
            ['createdAt' => 'DESC']
        );

        return $this->render('admin/comments.html.twig', [
            'comments' => $comments,
        ]);
    }

    #[Route('/contacts', name: 'contacts')]
    public function contacts(ContactRepository $contactRepository): Response
    {
        $contacts = $contactRepository->findBy(
            [],
            ['createdAt' => 'DESC']
        );

        return $this->render('admin/contacts.html.twig', [
            'contacts' => $contacts,
        ]);
    }
}
