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
     * @param  mixed $user
     * @return Response
     */
    #[Security("is_granted('ROLE_USER') and user || is_granted('ROLE_ADMIN')")]
    #[Route('/profile/{id}', name: 'user_profile')]
    public function profile(User $user): Response
    {
        return $this->render('user/user_profile.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * Edit a profile
     *
     * @param  mixed $user
     * @param  mixed $request
     * @param  mixed $entityManagerInterface
     * @return Response
     */
    #[Security("is_granted('ROLE_USER') and user || is_granted('ROLE_ADMIN')")]
    #[Route('/profile/{id}/edit', name: 'user_profile_edit')]
    public function edit(User $user, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $form = $this->createForm(UserProfileEditFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            $entityManagerInterface->persist($user);
            $entityManagerInterface->flush();

            $this->addFlash(
                'message',
                'Votre profil a été modifié avec succès !'
            );

            return $this->redirectToRoute('user_profile', ['id' => $user->getId()]);
        }

        return $this->render('user/user_profile_edit.html.twig', [
            'user' => $user,
            'editForm' => $form
        ]);
    }

    /**
     * Delete a profile
     *
     * @param  mixed $user
     * @param  mixed $entityManagerInterface
     * @return Response
     */
    #[Security("is_granted('ROLE_USER') and user || is_granted('ROLE_ADMIN')")]
    #[Route('/profile/{id}/delete', name: 'user_profile_delete')]
    public function delete(?User $user, EntityManagerInterface $entityManagerInterface): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($user) {
            $entityManagerInterface->remove($user);
            $entityManagerInterface->flush();

            if ($this->getUser()->getRoles() !== "ROLE_ADMIN") {
                $this->addFlash(
                    'message',
                    'Votre compte a été supprimé avec succès !'
                );

                return $this->redirectToRoute('app_login');
            } else {
                $this->addFlash(
                    'message',
                    'Le profil a été supprimé avec succès !'
                );

                return $this->redirectToRoute('app_admin_users');
            }
        }
    }
}
