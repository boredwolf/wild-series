<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{


    const SEASONS = [
        'game_of_thrones_season_1' => [
            'number' => 1,
            'year' => 2011,
            'description' => 'The first season of Game of Thrones...',
            'program' => 'game_of_thrones',
        ],
        'game_of_thrones_season_2' => [
            'number' => 2,
            'year' => 2012,
            'description' => 'The second season of Game of Thrones...',
            'program' => 'game_of_thrones',
        ],
        'breaking_bad_season_1' => [
            'number' => 1,
            'year' => 2008,
            'description' => 'The first season of Breaking Bad...',
            'program' => 'breaking_bad',
        ],
        'breaking_bad_season_2' => [
            'number' => 2,
            'year' => 2009,
            'description' => 'The second season of Breaking Bad...',
            'program' => 'breaking_bad',
        ],
        'friends_season_1' => [
            'number' => 1,
            'year' => 1994,
            'description' => 'The first season of Friends...',
            'program' => 'friends',
        ],
        'friends_season_2' => [
            'number' => 2,
            'year' => 1995,
            'description' => 'The second season of Friends...',
            'program' => 'friends',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::SEASONS as $key => $seasonData) {
            $season = new Season();
            $season->setNumber($seasonData['number']);
            $season->setYear($seasonData['year']);
            $season->setDescription($seasonData['description']);
            $season->setProgram($this->getReference($seasonData['program']));
            $manager->persist($season);
            $this->addReference($key, $season);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {

        return [
            ProgramFixtures::class
        ];
    }
}
