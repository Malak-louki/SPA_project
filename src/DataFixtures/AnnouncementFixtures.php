<?php

namespace App\DataFixtures;

use app\Entity\Announcement;
use App\Repository\AnnouncerRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AnnouncementFixtures extends Fixture implements DependentFixtureInterface
{
    protected AnnouncerRepository $announcerRepository;

    public function __construct(AnnouncerRepository $announcerRepository)
    {
        $this->announcerRepository = $announcerRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $announcers = $this->announcerRepository->findAll();
        $dateTime = new \DateTimeImmutable();
        $announcements = [
            (new Announcement())
                ->setTitle("Chien de la casse")
                ->setCreatedAt($dateTime)
                ->setUpdatedAt($dateTime),
            (new Announcement())
                ->setTitle("Chien gentil et mignon")
                ->setCreatedAt($dateTime)
                ->setUpdatedAt($dateTime),
            (new Announcement())
                ->setTitle("Chien adorable")
                ->setCreatedAt($dateTime)
                ->setUpdatedAt($dateTime),
        ];
        foreach ($announcements as $announcement) {
            $nb = mt_rand(0, count($announcers) - 1);

            $announcer = $announcers[$nb];
            $announcement->setAnnouncer($announcer);
            $manager->persist($announcement);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}