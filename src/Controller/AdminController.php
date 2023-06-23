<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\ContactRepository;
use App\Repository\FigureRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function users(UserRepository $userRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        $data = $userRepository->getUsersByDate();
        $users = $paginatorInterface->paginate(
            $data,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/users.html.twig', [
            'users' => $users,
            'usersCount' => $data
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
    public function figures(FigureRepository $figureRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        $data = $figureRepository->getFiguresByDate();
        $figures = $paginatorInterface->paginate(
            $data,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/figures.html.twig', [
            'figures' => $figures,
            'figuresCount' => $data
        ]);
    }

    #[Route('/comments', name: 'comments')]
    public function comments(CommentRepository $commentRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        $data = $commentRepository->getCommentsByDate();
        $comments = $paginatorInterface->paginate(
            $data,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/comments.html.twig', [
            'comments' => $comments,
            'commentsCount' => $data
        ]);
    }

    #[Route('/contacts', name: 'contacts')]
    public function contacts(ContactRepository $contactRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        $data = $contactRepository->getContactsByDate();
        $contacts = $paginatorInterface->paginate(
            $data,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/contacts.html.twig', [
            'contacts' => $contacts,
            'contactsCount' => $data
        ]);
    }
}
