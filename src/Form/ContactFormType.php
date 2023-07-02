<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'required' => true,
                    'label' => 'Nom *',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Entrez un message svp',
                        ]),
                    ],
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'required' => true,
                    'label' => 'Mail *',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Entrez un message svp',
                        ]),
                    ],
                ]
            )
            ->add(
                'subject',
                TextType::class,
                [
                    'required' => true,
                    'label' => 'Sujet *',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Entrez un message svp',
                        ]),
                    ],
                ]
            )
            ->add(
                'message',
                TextType::class,
                [
                    'required' => true,
                    'label' => 'Message *',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Entrez un message svp',
                        ]),
                        new Length([
                            'min' => 10,
                            'minMessage' => 'Votre message doit contenir au moins {{ limit }} caractères',
                            'max' => 600,
                        ]),
                    ],
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}