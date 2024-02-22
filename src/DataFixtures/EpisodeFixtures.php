<?php


namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{

    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }


    public function load(ObjectManager $manager): void
    {
        for ($y = 1; $y < 3; $y++) {
            for ($z = 1; $z < 5; $z++) {
                for ($i = 1; $i <= 10; $i++) {
                    $faker = Factory::create();
                    $episode = new Episode();
                    $slug = $this->slugger->slug($faker->word());
                    $episode->setSlug($slug);
                    $episode->setTitle($faker->word());
                    $episode->setNumber($i);
                    $episode->setDuration($faker->numberBetween(20, 70));
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
