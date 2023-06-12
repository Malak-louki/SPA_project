<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Repository\DogRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

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
                ->setPath("img/kim.jpg")
                ->setDog($dogs[2]),
            (new Image())
                ->setPath("img/kim1.jpg")
                ->setDog($dogs[2]),
            (new Image())
                ->setPath("img/cocaineDog.jpg")
                ->setDog($dogs[1]),
            (new Image())
                ->setPath("img/cocaineDog1.jpg")
                ->setDog($dogs[1]),
            (new Image())
                ->setPath("img/babyGolden.jpg")
                ->setDog($dogs[0]),
            (new Image())
                ->setPath("img/babyGolden2.jpg")
                ->setDog($dogs[0]),
            (new Image())
                ->setPath("img/babyGolden3.jpg")
                ->setDog($dogs[0]),
            (new Image())
                ->setPath("img/defaultImage.jpg")
                ->setDog($dogs[3]),
            (new Image())
                ->setPath("img/images.jpg")
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