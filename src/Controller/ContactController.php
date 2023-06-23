<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Service\Mailjet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contact', name: 'app_contact_')]
class ContactController extends AbstractController
{
    #[Route('', name: 'add')]
    public function add(Request $request, EntityManagerInterface $entityManagerInterface, Mailjet $mailjet): Response
    {
        $contact = new Contact();

        /**
         * @var UserEntity
         */
        $user = $this->getUser();
        if ($this->getUser()) {
            $contact->setFullName($user->getFirstname() . ' ' . $user->getLastname())
                ->setEmail($user->getEmail());
        }

        $form = $this->createForm(ContactFormType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact->setIsAnswered(0);
            $contact = $form->getData();

            $entityManagerInterface->persist($contact);
            $entityManagerInterface->flush();

            $mailjet->getEmailMessage(
                $contact->getEmail(),
                $contact->getFullName(),
                $contact->getSubject(),
                $contact->getMessage(),
                4838475
            );

            $this->addFlash(
                'message',
                'Votre message a été envoyé avec succès !'
            );

            return $this->redirectToRoute('app_contact_add');
        }

        return $this->render('contact/contact_create.html.twig', [
            'contactCreateForm' => $form->createView(),
            'user'
        ]);
    }

    #[Route('/{id}', name: 'show')]
    public function contact(?Contact $contact): Response
    {
        if (!$contact) {
            return $this->redirectToRoute('app_admin_contacts');
        }

        return $this->render('contact/contact_show.html.twig', [
            'contact' => $contact,
        ]);
    }

    #[Route('/{id}/delete', name: 'delete')]
    public function delete(?Contact $contact, EntityManagerInterface $entityManagerInterface): Response
    {
        if ($contact) {
            $entityManagerInterface->remove($contact);
            $entityManagerInterface->flush();

            $this->addFlash(
                'message',
                'Le message a été supprimé avec succès !'
            );

            return $this->redirectToRoute('app_admin_contacts');
        }
    }
}
