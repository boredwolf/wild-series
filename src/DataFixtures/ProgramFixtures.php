<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{


    const PROGRAMS = [
        'game_of_thrones' => [
            'title' => 'Game of Thrones',
            'synopsis' => 'In the land of Westeros, noble families vie for control of the Iron Throne...',
            'category_reference' => 'category_Fantastique',
        ],
        'breaking_bad' => [
            'title' => 'Breaking Bad',
            'synopsis' => 'A high school chemistry teacher turned methamphetamine manufacturer navigates the criminal underworld...',
            'category_reference' => 'category_Drama',
        ],
        'friends' => [
            'title' => 'Friends',
            'synopsis' => 'Follows the lives of six friends living in Manhattan...',
            'category_reference' => 'category_Comédie',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::PROGRAMS as $key => $programData) {
            $program = new Program();
            $program->setTitle($programData['title']);
            $program->setSynopsis($programData['synopsis']);
            $program->setCategory($this->getReference($programData['category_reference']));
            $manager->persist($program);
            $this->addReference($key, $program);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {

        return [
            CategoryFixtures::class
        ];
    }
}
