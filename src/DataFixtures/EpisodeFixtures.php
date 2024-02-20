<?php


namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{


    public function load(ObjectManager $manager): void
    {
        for ($y = 1; $y < 3; $y++) {
            for ($z = 1; $z < 5; $z++) {
                for ($i = 1; $i <= 10; $i++) {
                    $faker = Factory::create();
                    $episode = new Episode();
                    $episode->setTitle($faker->word());
                    $episode->setNumber($i);
                    $episode->setSynopsis($faker->paragraph());
                    $episode->setSeason($this->getReference("program_" . $y . "_season_" . $z));
                    $manager->persist($episode);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {

        return [
            SeasonFixtures::class
        ];
    }
}
