<?php

namespace App\Controller;

use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * Delete a comment
     *
     * @param  EntityManagerInterface $entityManager EntityManager
     * @param  Comment                $comment       Comment
     * @return Response
     */
    #[Security("is_granted('ROLE_USER') and user === figure.getCreatedBy() || is_granted('ROLE_ADMIN')")]
    #[Route('/comment/{id}/delete', name: 'comment_delete')]
    public function delete(EntityManagerInterface $entityManager, ?Comment $comment): Response
    {
        if ($comment) {
            $entityManager->remove($comment);
            $entityManager->flush();

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
