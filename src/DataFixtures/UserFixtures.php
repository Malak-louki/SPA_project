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
                ->setFirstName("Amélie")
                ->setLastName("Roche")
                ->setEmail("amelie@gmail.com")
                ->setPassword("aze123")
                ->setCity("lyon"),
            (new Admin())
                ->setFirstName("Admin Prénom")
                ->setLastName("Admin NOM")
                ->setEmail("admin@gmail.com")
                ->setPassword("aze123")
                ->setCity("Roanne"),
            (new Adopter())
                ->setTel("+33654125214")
                ->setFirstName("Lilia")
                ->setLastName("Lamini")
                ->setEmail("lilia@gmail.com")
                ->setPassword("aze123")
                ->setCity("lyon"),
            (new Admin())
                ->setFirstName("Admin Prénom")
                ->setLastName("Admin NOM")
                ->setEmail("admin@gmail.com")
                ->setPassword("aze123")
                ->setCity("Roanne"),
            (new Adopter())
                ->setTel("+33654167214")
                ->setFirstName("Mimi")
                ->setLastName("Xouxou")
                ->setEmail("mimi@gmail.com")
                ->setPassword("aze123")
                ->setCity("lyon"),
            (new Announcer())
                ->setFirstName("Lilia")
                ->setLastName("Lamini")
                ->setEmail("lilia@gmail.com")
                ->setPassword("aze123")
                ->setCity("lyon")
                ->setTel("+33654125214"),
            (new Adopter())
                ->setFirstName("Mimi")
                ->setLastName("Xouxou")
                ->setEmail("mimi@gmail.com")
                ->setPassword("aze123")
                ->setCity("lyon")
                ->setTel("+33654167214"),
            (new Announcer())
                ->setFirstName("Annonceur")
                ->setLastName("Elevage des beaux chiens")
                ->setEmail("elevage@gmail.com")
                ->setPassword("aze123")
                ->setCity("lyon"),
            (new Announcer())
                ->setFirstName("Annonceur")
                ->setLastName("Elevage du soleil")
                ->setEmail("elevage1@gmail.com")
                ->setPassword("aze123")
                ->setCity("lyon"),
            (new Announcer())
                ->setFirstName("Annonceur")
                ->setLastName("SPA de Brignais")
                ->setEmail("spa1@gmail.com")
                ->setPassword("aze123")
                ->setCity("lyon"),
            (new Announcer())
                ->setFirstName("Annonceur")
                ->setLastName("SPA Marrenes")
                ->setEmail("spa@gmail.com")
                ->setPassword("aze123")
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