<?php

namespace App\Form\Filter;

use App\Entity\Race;
use App\Form\Filter\AnnouncementFilter;
use App\Repository\RaceRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class DogFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $announcement = $options['announcement'];
        $builder
        ->add('isAdopted', CheckboxType::class, [
            'label' => 'Chien déjà adopté(s)',
            'required' => false,
        ])
            ->add('isLof', CheckboxType::class, [
                'label' => 'LOF',
                'required' => false,
            ])
            ->add('race', EntityType::class, [
                'class' => Race::class,
                'label'=> 'Race(s)',
                'multiple' => false,
                'expanded' => false,
                'choice_label' => 'name',
                'required' => false,
                'query_builder' => function (RaceRepository $raceRepository) use ($announcement) {
                    return $raceRepository
                        ->createQueryBuilder('r')
                        ->innerJoin('r.dogs', 'dog')
                        ->where('dog.announcement = :a')
                        ->setParameter('a', $announcement);
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            
            'data_class' => AnnouncementFilter::class, 
            'announcement' => null,

        ]);
    }
}