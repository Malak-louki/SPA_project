<?php

namespace App\Form;

use App\Entity\Request;
use App\Entity\Dog;
use App\Repository\DogRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class FirstRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $announcement = $options['announcement'];
        $builder
            ->add('dogs', EntityType::class, [
                'class' => Dog::class,
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
                'query_builder' => function (DogRepository $dogRepository) use ($announcement) {
                    return $dogRepository
                        ->createQueryBuilder('d')
                        ->innerJoin('d.announcement', 'a')
                        ->andWhere('a.id = :announcement')
                        ->setParameter(':announcement', $announcement->getId());
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Request::class,
        ]);
        $resolver->setRequired([
            'announcement',
        ]);
    }
}