<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Adopter;
use App\Entity\Announcer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    protected UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        $users = [
            (new Admin())
                ->setFirstName("Jean")
                ->setLastName("Dupont")
                ->setEmail("jeanAdmin@gmail.com")
                ->setPassword("azerty123")
                ->setCity("lyon"),
            (new Adopter())
                ->setFirstName("Jean")
                ->setLastName("Dupont")
                ->setEmail("jeanAdopter@gmail.com")
                ->setPassword("azerty123")
                ->setCity("lyon")
                ->setTel("+33654125214"),
            (new Announcer())
                ->setFirstName("Jean")
                ->setLastName("Dupont")
                ->setEmail("jeanAnnouncer@gmail.com")
                ->setPassword("azerty123")
                ->setCity("lyon"),
            (new Announcer())
                ->setFirstName("Jean")
                ->setLastName("Dupont")
                ->setEmail("jeanAnnounceLaPocalyspe@gmail.com")
                ->setPassword("azerty123")
                ->setCity("lyon"),
        ];

        foreach ($users as $user) {
            $hashedPassword = $this->hasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            $manager->persist($user);
        }


        $manager->flush();
    }
}