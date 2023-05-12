<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Figure;
use App\Form\CommentFormType;
use App\Form\FigureFormType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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

    #[Route('/figure/add', name: 'figure_add')]
    public function add(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        //$this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_USER']);
        
        $figure = new Figure();
        $form = $this->createForm(FigureFormType::class, $figure);

        $form->handleRequest($request);

        $figure->setUpdatedAt(new \DateTimeImmutable());
        $figure->setCreatedBy($this->getUser());
        
        if ($form->isSubmitted() && $form->isValid()) {
            dump($figure);
            if (!$figure->getCreatedAt()) {
                $figure->setCreatedAt(new \DateTimeImmutable());
            }

            $images = $form->getData()->getImages();
                
            foreach ($images as $img){
                $img->setFigure($figure);
                $figure->addImage($img);
                
            }

            $videos = $form->getData()->getVideos();
                
            foreach ($videos as $video){
                $video->setFigure($figure);
                $figure->addVideo($video);
                
            }
            
            $entityManagerInterface->persist($figure);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('figure_show', ['slug' => $figure->getSlug()]);
        }

        return $this->render('figure/figure_create.html.twig', [
            'figureCreateForm' => $form->createView(),
        ]);
    }

    #[Route('/figure/{slug}', name: 'figure_show')]
    public function figure(?Figure $figure, Request $request, EntityManagerInterface $entityManagerInterface, PaginatorInterface $paginationInterface): Response
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

        $data = $figure->getComments();
        $comments = $paginationInterface->paginate($data, $request->query->getInt('page', 1), 3);
    
        return $this->render('figure/figure_show.html.twig', [
            'figure' => $figure,
            'commentForm' => $form->createView(),
            'comments' => $comments
        ]);
    }

    #[Route('/figure/{id}/delete', name: 'figure_delete')]
    public function delete(Figure $figure, EntityManagerInterface $entityManagerInterface): Response
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_USER']);
        
        if ($figure) {
            $entityManagerInterface->remove($figure);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('home');
        }
    }

}
