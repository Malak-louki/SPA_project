<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Repository\DogRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ImageFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(protected DogRepository $dogRepository)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $dogs = $this->dogRepository->findAll();

        $images = [
            (new Image())
                ->setPath('kim.jpg')
                ->setDog($dogs[2]),
            (new Image())
                ->setPath('kim1.jpg')
                ->setDog($dogs[2]),
            (new Image())
                ->setPath('cocaineDog.jpg')
                ->setDog($dogs[1]),
            (new Image())
                ->setPath('cocaineDog1.jpg')
                ->setDog($dogs[1]),
            (new Image())
                ->setPath('babyGolden.jpg')
                ->setDog($dogs[0]),
            (new Image())
                ->setPath('babyGolden2.jpg')
                ->setDog($dogs[0]),
            (new Image())
                ->setPath('babyGolden3.jpg')
                ->setDog($dogs[0]),
            (new Image())
                ->setPath('defaultImage.jpg')
                ->setDog($dogs[3]),
            (new Image())
                ->setPath('images.jpg')
                ->setDog($dogs[4]),
        ];

        foreach ($images as $image) {
            $manager->persist($image);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            DogFixtures::class,
        ];
    }
}
