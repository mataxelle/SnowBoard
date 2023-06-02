<?php

namespace App\Controller;

use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/comment/{id}/delete', name: 'comment_delete')]
    public function index(EntityManagerInterface $entityManagerInterface, Comment $comment): Response
    {
        if ($comment) {
            $entityManagerInterface->remove($comment);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_admin_comments');
        }
    }
}
