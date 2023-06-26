<?php

namespace App\DataFixtures;

use App\Entity\Dog;
use App\Repository\AnnouncementRepository;
use App\Repository\RaceRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DogFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        protected AnnouncementRepository $announcementRepository,
        protected RaceRepository $raceRepository
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $announcements = $this->announcementRepository->findAll();
        $races = $this->raceRepository->findAll();
        $dogs = [
            (new Dog())
                ->setName('Kiro')
                ->setIsLof(false)
                ->setBackground("Il provient d'un élevage de la campagne")
                ->setIsPetFriendly(true)
                ->setDescription("Une boule d'énergie pour égailler votre vie")
                ->setIsAdopted(false)
                ->addRace($races[51]),
            (new Dog())
                ->setName('Doggo')
                ->setIsLof(true)
                ->setBackground('Renifleur de coke à Medellin')
                ->setIsPetFriendly(false)
                ->setDescription('Très vif mais à quelques tocs à cause de son métier')
                ->setIsAdopted(false)
                ->addRace($races[18]),
            (new Dog())
                ->setName('Kim')
                ->setIsLof(true)
                ->setBackground('A été abandonnée au bord de la route')
                ->setIsPetFriendly(true)
                ->setDescription('Est très câline')
                ->setIsAdopted(false)
                ->addRace($races[10]),
            (new Dog())
                ->setName('Brasco')
                ->setIsLof(false)
                ->setBackground('Il gère un cartel')
                ->setIsPetFriendly(true)
                ->setDescription('Pire ennemi de Doggo')
                ->setIsAdopted(false)
                ->addRace($races[20]),
            (new Dog())
                ->setName('Pazzi (non dispo)')
                ->setIsLof(false)
                ->setBackground('Retrouvé dans une poubelle derrière une pizzeria')
                ->setIsPetFriendly(true)
                ->setDescription('Il est traumatisé des pizzas, il est donc obèse, il aboie aussi avec un accent et il a une grande gesture')
                ->setIsAdopted(true)
                ->addRace($races[1]),
            (new Dog())
                ->setName('Loulou (non dispo)')
                ->setIsLof(false)
                ->setBackground('Passé Loulou')
                ->setIsPetFriendly(true)
                ->setDescription('Description de Loulou ')
                ->setIsAdopted(true)
                ->addRace($races[78]),
            (new Dog())
                ->setName('Oudide (non dispo)')
                ->setIsLof(true)
                ->setBackground('Passé Oudide')
                ->setIsPetFriendly(true)
                ->setDescription('Description de Oudide ')
                ->setIsAdopted(true)
                ->addRace($races[59]),
        ];

        foreach ($dogs as $dog) {
            $nb = mt_rand(0, count($announcements) - 1);

            $dog->setAnnouncement($announcements[$nb]);
            $manager->persist($dog);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AnnouncementFixtures::class,
            RaceFixtures::class,
        ];
    }
}