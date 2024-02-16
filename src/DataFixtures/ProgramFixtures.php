<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{


    const PROGRAMS = [
        ['title' => 'Lord of the Rings',
            'synopsis' => 'In the land of Mordor...',
            'category_reference' => 'category_Fantastique'
        ],
        [
            'title' => 'The Matrix',
            'synopsis' => 'Welcome to the desert of the real...',
            'category_reference' => 'category_Science-fiction'
        ],
        [
            'title' => 'Jurassic Park',
            'synopsis' => 'Welcome to Jurassic Park...',
            'category_reference' => 'category_Aventure'
        ],
        [
            'title' => 'The Shawshank Redemption',
            'synopsis' => 'Fear can hold you prisoner...',
            'category_reference' => 'category_Thriller'
        ],
        [
            'title' => 'Inception',
            'synopsis' => 'Your mind is the scene of the crime...',
            'category_reference' => 'category_Thriller'
        ]
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::PROGRAMS as $key => $programData) {
            $program = new Program();
            $program->setTitle($programData['title']);
            $program->setSynopsis($programData['synopsis']);
            $program->setCategory($this->getReference($programData['category_reference']));
            $manager->persist($program);
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
