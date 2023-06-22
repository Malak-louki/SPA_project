<?php

namespace App\Form;

use App\Entity\Adopter;
use App\Entity\Department;
use App\Repository\DepartmentRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdopterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'firstName',
                TextType::class,
                [
                    'required' => false,
                    'label' => 'Prénom',
                ]
            )
            ->add(
                'lastName',
                TextType::class,
                [
                    'required' => false,
                    'label' => 'Nom',
                ]
            )
            ->add(
                'tel', TextType::class,
                [
                    'required' => true,
                    'label' => 'Téléphone',
                ]
            )
            ->add(
                'city', TextType::class,
                [
                    'required' => false,
                    'label' => 'Ville',
                ]
            )
            ->add('department', EntityType::class, [
                'label' => 'Département',
                'required' => false,
                'class' => Department::class,
                'query_builder' => function (DepartmentRepository $er) {
                    return $er->createQueryBuilder('d')->orderBy('d.name', 'ASC');
                },
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adopter::class,
        ]);
    }
}