<?php

namespace App\DataFixtures;

use App\Entity\Race;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RaceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $races = [
            'affenpinscher',
            'africanis',
            'american staffordshire',
            'airedale terrier',
            'akita américan',
            'akita inu',
            'barzoi',
            'basenji',
            'beagle',
            'berger allemand',
            'berger australien',
            'berger belge tervueren',
            'berger shetland',
            'berger blanc suisse',
            'bichon',
            'bichon maltais',
            'border collie',
            'bouvier australien',
            'bouvier bernois',
            "bouvier d'Appenzeller",
            "bouvier d'Entlebuch",
            'bouvier suisse',
            'boxer',
            'braque de weimar',
            'briard',
            'bouledog français',
            'bouledog anglais',
            'caniche',
            'caniche nain',
            'caniche toy',
            'carlin',
            'chien de Rhodésie',
            "chien d'eau portugais",
            'chien nu méxicain',
            'chihuahua',
            'chow chow',
            'cockapoo',
            'corgi',
            'coton de tulear',
            'dalmatien',
            'danois',
            'doberman',
            'épagneul breton',
            'épagneul papillon',
            'finnois de laponie',
            'lévrier anglais',
            'lévrier afghan',
            'lévrier basset',
            'lévrier écossais',
            'lévrier whippet',
            'golden retriever',
            'husky',
            'kelpie',
            'labrador',
            'leonberg',
            'lhasa',
            'malamute',
            'malinois',
            'mastiff',
            'mastiff thibétain',
            'montagne des pyrénées',
            'pékinois',
            'pinscher',
            'pinscher nain',
            'teckel',
            'terre neuve',
            'pitbull',
            'poméranien',
            'pointer anglais',
            'rottweiler',
            'samoyède',
            'saint-bernard',
            'schipperke',
            'spitz allemand',
            'spitz japonais',
            'spitz nain',
            'schnauzer',
            'setter anglais',
            'setter irlandais',
            'sharpei',
            'shiba inu',
            'yorkshire',
        ];
        foreach ($races as $race) {
            $newRace = (new Race())
                ->setName(ucfirst($race));
            $manager->persist($newRace);
        }

        $manager->flush();
    }
}
