<?php

namespace App\Form;

use App\Entity\Dog;
use App\Entity\Race;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddDogFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                null,
                [
                    "label" => 'Nom du chien',
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'Entrez le nom de votre chien',
                    ],
                ]
            )
            ->add(
                'isLof', CheckboxType::class,
                [
                    "label" => "Est Lof",
                    "required" => false
                ]
            )
            ->add('background', TextType::class, [
                "label" => "Antécédents",
            ])
            ->add(
                'isPetFriendly', CheckboxType::class,
                [
                    "label" => "Aimable avec les autres animaux",
                    "required" => false
                ]
            )
            ->add('description', TextType::class, [
                "label" => "Description",
            ])
            ->add(
                'isAdopted', CheckboxType::class,
                [
                    "required" => false,
                    "label" => "Est adopté",
                    // "disabled" => is_null($options['data']->getId()),
                ]
            )
            ->add(
                'races', EntityType::class,
                [
                    "label" => "Races",
                    'class' => Race::class,
                    'choice_label' => 'name',
                    'required' => false,
                    'multiple' => true,
                    'expanded' => true,
                ]
            )
            ->add(
                'images', CollectionType::class,
                [
                    'entry_type' => ImageType::class,
                    'entry_options' => [
                        'label' => false,
                    ],
                    'label' => 'Images',
                    'prototype_name' => '__images__',
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
            'data_class' => Dog::class,
        ]);
    }
}