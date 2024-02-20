<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{


    public function load(ObjectManager $manager): void
    {
        for ($y = 1; $y < 3; $y++) {
            for ($i = 1; $i <= 5; $i++) {
                $faker = Factory::create();
                $season = new Season();
                $season->setNumber($i);
                $season->setYear($faker->year());
                $season->setDescription($faker->paragraph(3, true));
                $season->setProgram($this->getReference('program_' . $y));
                $manager->persist($season);
                $this->addReference("program_" . $y . "_season_" . $i, $season);
            }
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
