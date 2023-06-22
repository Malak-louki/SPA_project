<?php

namespace App\Form;

use App\Entity\Conversation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

// use Symfony\Component\Validator\Constraints\NotBlank;

class ConversationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                // 'mapped' => false,
                'label' => false,
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Entrez votre message',
                    ]),
                    new Assert\Length([
                        'min' => 200,
                        'minMessage' => 'Votre message doit contenir au moins {{ limit }} caractères',
                        'max' => 12000,
                        'maxMessage' => 'Votre message doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Conversation::class,
        ]);
    }
}