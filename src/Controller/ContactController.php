<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, EntityManagerInterface $entityManagerInterface): Response
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

            $this->addFlash(
                'message',
                'Votre message a été envoyé avec succès !'
            );

            return $this->redirectToRoute('app_contact');
        } else {
            $this->addFlash(
                'message',
                $form->getErrors()
            );
        }

        return $this->render('contact/contact_create.html.twig', [
            'contactCreateForm' => $form->createView(),
            'user'
        ]);
    }
}
