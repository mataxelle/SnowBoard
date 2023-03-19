<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Form\FigureFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FigureController extends AbstractController
{
    #[Route('/figure', name: 'app_figure')]
    public function index(): Response
    {
        return $this->render('figure/index.html.twig', [
            'controller_name' => 'FigureController',
        ]);
    }

    #[Route('/add', name: 'add')]
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

            $entityManagerInterface->persist($figure);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('figure/figure_create.html.twig', [
            'figureCreateForm' => $form->createView(),
        ]);
    }
}
