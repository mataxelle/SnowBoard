<?php

namespace App\Controller;

use App\Repository\FigureRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(FigureRepository $figureRepository, Request $request, PaginatorInterface $paginationInterface): Response
    {
        $data = $figureRepository->getFiguresByDate();
        $figures = $paginationInterface->paginate(
            $data,
            $request->query->getInt('page', 1),
            9
        );
        return $this->render('home/index.html.twig', [
            'figures' => $figures,
        ]);
    }
}
