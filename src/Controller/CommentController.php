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
    public function delete(EntityManagerInterface $entityManagerInterface, ?Comment $comment): Response
    {
        if ($comment) {
            $entityManagerInterface->remove($comment);
            $entityManagerInterface->flush();

            $this->addFlash(
                'message',
                'Le commentaire a été supprimé avec succès !'
            );

            if ($this->getUser()->getRoles() !== "ROLE_ADMIN") {
                return $this->redirectToRoute('figure_show', ['slug' => $comment->getFigure()->getSlug()]);
            } else {
                return $this->redirectToRoute('app_admin_comments');
            }
        }
    }
}
