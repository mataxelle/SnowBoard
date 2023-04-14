<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/profile/{id}', name: 'user_profile')]
    public function profile(User $user): Response
    {
        return $this->render('user/user_profile.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profile/{id}/delete', name: 'user_profile_delete')]
    public function delete(User $user, EntityManagerInterface $entityManagerInterface): Response
    {
        if ($user) {
            $entityManagerInterface->remove($user);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('home');
        }
    }
}
