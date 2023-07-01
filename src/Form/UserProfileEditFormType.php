<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserProfileEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'firstname', TextType::class,
                [
                    'required' => false
                ]
            )
            ->add(
                'lastname', TextType::class,
                [
                    'required' => false
                ]
            )
            ->add(
                'imageProfileFile', VichImageType::class,
                [
                    'required'   => false,
                    'download_uri' => false,
                ]
            )
            ->add(
                'email', EmailType::class,
                [
                    'required' => false
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => User::class]);
    }
}
