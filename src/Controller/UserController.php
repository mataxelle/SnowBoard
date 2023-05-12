<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserProfileEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/profile/{id}', name: 'user_profile')]
    public function profile(User $user): Response
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_USER']);

        return $this->render('user/user_profile.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profile/{id}/edit', name: 'user_profile_edit')]
    public function edit(User $user, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_USER']);
        
        $form = $this->createForm(UserProfileEditFormType::class, $user);
        
        $form->handleRequest($request);

        $user->setUpdatedAt(new \DateTimeImmutable());

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManagerInterface->persist($user);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('user_profile', ['id' => $user->getId()]);
        }

        return $this->render('user/user_profile_edit.html.twig', [
            'user' => $user,
            'editForm' => $form
        ]);
    }

    #[Route('/profile/{id}/delete', name: 'user_profile_delete')]
    public function delete(User $user, EntityManagerInterface $entityManagerInterface): Response
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_USER']);
        
        if ($user) {
            $entityManagerInterface->remove($user);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('home');
        }
    }
}
