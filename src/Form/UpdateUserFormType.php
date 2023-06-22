<?php

namespace App\Form;

use App\Entity\Department;
use App\Entity\User;
use App\Repository\DepartmentRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UpdateUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,
            [
                'required'=>false,
                'label'=>'Email'
            ])
            ->add(
                'city', TextType::class,
                [
                    'required' => false,
                    'label'=> 'Ville',
                ]
            )
            ->add(
                'lastName',
                TextType::class,
                [
                    'required' => false,
                    'label'=> 'Nom',
                ]
            )
            ->add(
                'city', TextType::class,
                [
                    'required' => false,
                    'label'=> 'Ville',
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
            'data_class' => User::class,
        ]);
    }
}
