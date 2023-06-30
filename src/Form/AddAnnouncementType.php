<?php

namespace App\Form;

use App\Entity\Announcement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddAnnouncementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title', TextType::class,
                [
                    'required' => true,
                    'label' => 'Titre',
                ]
            )
            ->add(
                'generalInformation', TextType::class,
                [
                    'required' => true,
                    'label' => "Information de l'annonce",
                ]
            )
            ->add(
                'dogs', CollectionType::class,
                [
                    'entry_type' => AddDogFormType::class,
                    'entry_options' => [
                        'label' => false,
                    ],
                    'label' => 'Chien',
                    'prototype_name' => '__dogs__',
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Announcement::class,
        ]);
    }
}
