<?php

namespace App\Form;

use App\Entity\Dog;
use App\Entity\Race;
use App\Form\Filter\AnnouncementFilter;
use App\Repository\DogRepository;
use App\Repository\RaceRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnouncementFiltreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isLof', CheckboxType::class, [
                'label' => 'LOF',
                'required' => false,
            ])
            ->add('isAdopted', CheckboxType::class, [
                'label' => 'Toutes les annonces',
                'required' => false,
            ])
            // ->add('announcement')
            ->add('race', EntityType::class, [
                'class' => Race::class,
                'multiple' => false,
                'expanded' => false,
                'choice_label' => 'name',
                'required' => false,
                'query_builder' => function (RaceRepository $raceRepository) {
                    return $raceRepository
                        ->createQueryBuilder('r')
                        ->orderBy('r.name', 'ASC');
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AnnouncementFilter::class,
        ]);
    }
}