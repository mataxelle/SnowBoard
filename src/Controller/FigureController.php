<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Figure;
use App\Form\CommentFormType;
use App\Form\FigureFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FigureController extends AbstractController
{
    #[Route('/figure', name: 'figures_all')]
    public function index(): Response
    {
        return $this->render('figure/index.html.twig', [
            'controller_name' => 'FigureController',
        ]);
    }

    #[Route('/add', name: 'figure_add')]
    public function add(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $figure = new Figure();
        $form = $this->createForm(FigureFormType::class, $figure);

        $form->handleRequest($request);

        $figure->setUpdatedAt(new \DateTimeImmutable());
        $figure->setCreatedBy($this->getUser());

        if ($form->isSubmitted() && $form->isValid()) {

            if (!$figure->getCreatedAt()) {
                $figure->setCreatedAt(new \DateTimeImmutable());
            }

            $images = $form->getData()->getImages();
                
            foreach ($images as $img){
                $img->setFigure($figure);
                $figure->addImage($img);
                
            }

            $entityManagerInterface->persist($figure);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('figure/figure_create.html.twig', [
            'figureCreateForm' => $form->createView(),
        ]);
    }

    #[Route('/figure/{slug}', name: 'figure_show')]
    public function figure(?Figure $figure, Request $request, EntityManagerInterface $entityManagerInterface, UserRepository $userRepository): Response
    {
        if (!$figure) {
            return $this->redirectToRoute('home');
        }

        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);

        $form->handleRequest($request);

        $comment->setUpdatedAt(new \DateTimeImmutable());
        $comment->setFigure($figure);
        $comment->setUser($this->getUser());

        if ($form->isSubmitted() && $form->isValid()) {

            if (!$comment->getCreatedAt()) {
                $comment->setCreatedAt(new \DateTimeImmutable());
            }

            
            $entityManagerInterface->persist($comment);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('figure_show', ['slug' => $figure->getSlug()]);
        }

        $comments = $figure->getComments();
    
        return $this->render('figure/figure_show.html.twig', [
            'figure' => $figure,
            'commentForm' => $form->createView(),
            'comments' => $comments
        ]);
    }

}
