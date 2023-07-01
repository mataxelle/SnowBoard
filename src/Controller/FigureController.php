<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Figure;
use App\Form\CommentFormType;
use App\Form\FigureFormType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FigureController extends AbstractController
{
    /**
     * Display all figures
     *
     * @return Response
     */
    #[Route('/figure', name: 'figures_all')]
    public function index(): Response
    {
        return $this->render('figure/index.html.twig', ['controller_name' => 'FigureController']);
    }

    /**
     * Create a Figure
     *
     * @param  Request                $request       Request
     * @param  EntityManagerInterface $entityManager EntityManager
     * @return Response
     */
    #[Security("is_granted('ROLE_USER') || is_granted('ROLE_ADMIN')")]
    #[Route('/figure/add', name: 'figure_add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $figure = new Figure();
        $form = $this->createForm(FigureFormType::class, $figure);

        $form->handleRequest($request);

        $figure->setCreatedBy($this->getUser());
        if ($form->isSubmitted() && $form->isValid()) {

            $images = $form->getData()->getImages();

            foreach ($images as $img) {
                $img->setFigure($figure);
                $figure->addImage($img);
            }

            $videos = $form->getData()->getVideos();

            foreach ($videos as $video) {
                $video->setFigure($figure);
                $figure->addVideo($video);
            }

            $figure = $form->getData();

            $entityManager->persist($figure);
            $entityManager->flush();

            $this->addFlash(
                'message',
                'Votre figure a été créé avec succès !'
            );

            return $this->redirectToRoute('figure_show', ['slug' => $figure->getSlug()]);
        }

        return $this->render('figure/figure_create.html.twig', ['figureCreateForm' => $form->createView()]);
    }

    /**
     * Show a figure
     *
     * @param  Figure                 $figure              Figure
     * @param  Request                $request             Request
     * @param  EntityManagerInterface $entityManager       EntityManager
     * @param  PaginatorInterface     $paginationInterface PaginatorInterface
     * @return Response
     */
    #[Route('/figure/{slug}', name: 'figure_show')]
    public function figure(?Figure $figure, Request $request, EntityManagerInterface $entityManager, PaginatorInterface $paginationInterface): Response
    {
        if (!$figure) {
            return $this->redirectToRoute('home');
        }

        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);

        $form->handleRequest($request);

        $comment->setFigure($figure);
        $comment->setCreatedBy($this->getUser());

        if ($form->isSubmitted() && $form->isValid()) {

            $comment = $form->getData();

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('figure_show', ['slug' => $figure->getSlug()]);
        }

        $data = $figure->getComments();
        $comments = $paginationInterface->paginate($data, $request->query->getInt('page', 1), 10);

        return $this->render(
            'figure/figure_show.html.twig',
            [
                'figure'      => $figure,
                'commentForm' => $form->createView(),
                'comments'    => $comments
            ]
        );
    }

    /**
     * Edit a figure
     *
     * @param  Figure                 $figure        Figure
     * @param  Request                $request       Request
     * @param  EntityManagerInterface $entityManager EntityManager
     * @return Response
     */
    #[Security("is_granted('ROLE_USER') and user === figure.getCreatedBy() || is_granted('ROLE_ADMIN')")]
    #[Route('/figure/{id}/edit', name: 'figure_edit')]
    public function edit(?figure $figure, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FigureFormType::class, $figure);

        $form->handleRequest($request);

        $figure->setCreatedBy($this->getUser());

        if ($form->isSubmitted() && $form->isValid()) {

            $images = $form->getData()->getImages();

            foreach ($images as $img) {
                $img->setFigure($figure);
                $figure->addImage($img);
            }

            $videos = $form->getData()->getVideos();

            foreach ($videos as $video) {
                $video->setFigure($figure);
                $figure->addVideo($video);
            }

            $figure = $form->getData();

            $entityManager->persist($figure);
            $entityManager->flush();

            $this->addFlash(
                'message',
                'Votre figure a été modifiée avec succès !'
            );

            return $this->redirectToRoute('figure_show', ['slug' => $figure->getSlug()]);
        }

        return $this->render('figure/figure_edit.html.twig', ['figureCreateForm' => $form->createView()]);
    }

    /**
     * Delete a figure
     *
     * @param  Figure                 $figure Figure
     * @param  EntityManagerInterface $entityManager EntityManager
     * @return Response
     */
    #[Security("is_granted('ROLE_USER') and user === figure.getCreatedBy() || is_granted('ROLE_ADMIN')")]
    #[Route('/figure/{id}/delete', name: 'figure_delete')]
    public function delete(?Figure $figure, EntityManagerInterface $entityManagerInterface): Response
    {
        if ($figure) {
            $entityManagerInterface->remove($figure);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_admin_figures');
        }
    }
}
