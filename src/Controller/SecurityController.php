<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Service\Mailjet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * Logg a user
     *
     * @param  AuthenticationUtils $authenticationUtils AuthenticationUtils
     * @return Response
     */
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        /*
        if ($this->getUser()) {
               return $this->redirectToRoute('target_path');
        }*/

        // Get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // Last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * Logout a user
     *
     * @return void
     */
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    /**
     * Register a user
     *
     * @param  Request                     $request Request
     * @param  UserPasswordHasherInterface $userPasswordHasher UserPasswordHasher
     * @param  EntityManagerInterface      $entityManager      EntityManagerInterface
     * @param  Mailjet                     $mailjet            Mailjet
     * @return Response
     */
    #[Route(path: '/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, Mailjet $mailjet): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->handleRequest($request);

        $user->setRoles(['ROLE_USER']);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $user = $form->getData();
            $entityManager->persist($user);
            $entityManager->flush();


            $name = $user->getFirstname();

            $mailjet->sendEmail($user->getEmail(), $name, 'Bienvenue', "Salut $name!! Ton inscription sera validé en cliquant sur le bouton çi-dessous !", 4769102);

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/register.html.twig', ['registrationForm' => $form->createView()]);
    }
}
