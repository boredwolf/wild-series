<?php


namespace App\DataFixtures;

use App\Entity\Actor;
use App\Repository\ProgramRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{

    private $programRepository;

    public function __construct(ProgramRepository $programRepository)
    {
        $this->programRepository = $programRepository;
    }

    public function load(ObjectManager $manager): void
    {

        $programs = $this->programRepository->findAll();
        

        for ($i = 1; $i <= 10; $i++) {
            $faker = Factory::create();
            $actor = new Actor();
            $actor->setFirstname($faker->firstName());
            $actor->setLastname($faker->lastName());
            $actor->setBirthDate($faker->dateTime());
            // Generate a random index within the range of the number of programs
            $randomIndex = mt_rand(0, count($programs) - 1);

            // Get a random program using the random index
            $randomProgram = $programs[$randomIndex];

            // Add the random program to the actor
            $actor->addProgram($randomProgram);

            $manager->persist($actor);
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
