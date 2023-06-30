<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserProfileEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * Display a profile
     *
     * @param  User $user User
     * @return Response
     */
    #[Security("is_granted('ROLE_USER') and user || is_granted('ROLE_ADMIN')")]
    #[Route('/profile/{id}', name: 'user_profile')]
    public function profile(User $user): Response
    {
        return $this->render('user/user_profile.html.twig', ['user' => $user]);
    }

    /**
     * Edit a profile
     *
     * @param  User                   $user User
     * @param  Request                $request Request
     * @param  EntityManagerInterface $entityManager EntityManager
     * @return Response
     */
    #[Security("is_granted('ROLE_USER') and user || is_granted('ROLE_ADMIN')")]
    #[Route('/profile/{id}/edit', name: 'user_profile_edit')]
    public function edit(User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserProfileEditFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash(
                'message',
                'Votre profil a été modifié avec succès !'
            );

            return $this->redirectToRoute('user_profile', ['id' => $user->getId()]);
        }

        return $this->render(
            'user/user_profile_edit.html.twig',
            [
                'user'     => $user,
                'editForm' => $form
            ]
        );
    }

    /**
     * Delete a profile
     *
     * @param  User                   $user User
     * @param  EntityManagerInterface $entityManager EntityManager
     * @return Response
     */
    #[Security("is_granted('ROLE_USER') and user || is_granted('ROLE_ADMIN')")]
    #[Route('/profile/{id}/delete', name: 'user_profile_delete')]
    public function delete(?User $user, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($user) {
            $entityManager->remove($user);
            $entityManager->flush();

            if ($this->getUser()->getRoles() !== "ROLE_ADMIN") {
                $this->addFlash(
                    'message',
                    'Votre compte a été supprimé avec succès !'
                );

                return $this->redirectToRoute('app_login');
            }

            $this->addFlash(
                'message',
                'Le profil a été supprimé avec succès !'
            );

            return $this->redirectToRoute('app_admin_users');
        }
    }
}
