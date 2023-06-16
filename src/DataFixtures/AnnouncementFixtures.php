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
        $newDate = new \DateTimeImmutable();
        $announcements = [
            (new Announcement())
                ->setTitle("Chien de la casse")
                ->setGeneralInformation('Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. '),
            (new Announcement())
                ->setTitle("Chien gentil et mignon")
                ->setGeneralInformation("Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que son contenu n'en soit modifié."),
            (new Announcement())
                ->setTitle("Chien adorable")
                ->setGeneralInformation("Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker."),
            (new Announcement())
                ->setTitle("Chien mimi")
                ->setGeneralInformation('Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. '),
            (new Announcement())
                ->setTitle("Chien merveilleux")
                ->setGeneralInformation('Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. '),
            (new Announcement())
                ->setTitle("Chiens chiens chiens")
                ->setGeneralInformation('Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. '),
            (new Announcement())
                ->setTitle("Chien foufou")
                ->setGeneralInformation('Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. '),
            (new Announcement())
                ->setTitle("Chiens joueurs")
                ->setGeneralInformation('Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. '),
            (new Announcement())
                ->setTitle("Chiens boubou-chouchou-moumou")
                ->setGeneralInformation('Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte.'),
        ];

        foreach ($announcements as $announcement) {
            $dateTime = (clone $newDate)->modify('-' . mt_rand(0, 5) . 'day');
            $updateTime = (clone $dateTime)->modify('+' . mt_rand(1, 5) . 'day');
            $nb = mt_rand(0, count($announcers) - 1);
            $announcer = $announcers[$nb];

            $announcement->setCreatedAt($dateTime);
            $announcement->setUpdatedAt($updateTime);
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