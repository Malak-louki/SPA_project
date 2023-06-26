<?php

namespace App\Form;

use App\Entity\Adopter;
use App\Entity\Request;
use App\Entity\Dog;
use App\Form\AdopterType;
use App\Form\ConversationType;
use App\Repository\DogRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class FirstRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $announcement = $options['announcement']; // Sans le configureOptions on récupère les données avec $options['data']->getAnnouncement();

        $builder
            ->add('dogs', EntityType::class, [
                'class' => Dog::class,
                'label' => false,
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
                'query_builder' => function (DogRepository $dogRepository) use ($announcement) {
                    return $dogRepository
                        ->createQueryBuilder('d')
                        ->innerJoin('d.announcement', 'a')
                        ->where('a.id = :announcement')
                        ->setParameter(':announcement', $announcement->getId())
                        ->andWhere('d.isAdopted = :is_adopted')
                        ->setParameter(':is_adopted', 0);
                }
            ])
            ->add('adopter', AdopterType::class, [
                'label' => false,
                'required' => true,
            ])
            ->add('conversations', CollectionType::class, [
                'entry_type' => ConversationType::class,
                'entry_options' => ['label' => false],
                'label' => false,
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