<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{


    const PROGRAMS = [
        'game_of_thrones' => [
            'title' => 'Game of Thrones',
            'synopsis' => 'In the land of Westeros, noble families vie for control of the Iron Throne...',
            'category_reference' => 'category_Fantastique',
            'reference_id' => 1
        ],
        'breaking_bad' => [
            'title' => 'Breaking Bad',
            'synopsis' => 'A high school chemistry teacher turned methamphetamine manufacturer navigates the criminal underworld...',
            'category_reference' => 'category_Drama',
            'reference_id' => 2

        ],
        'friends' => [
            'title' => 'Friends',
            'synopsis' => 'Follows the lives of six friends living in Manhattan...',
            'category_reference' => 'category_Comédie',
            'reference_id' => 3

        ],
    ];

    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::PROGRAMS as $key => $programData) {
            $program = new Program();
            $slug = $this->slugger->slug($programData['title']);
            $program->setSlug($slug);
            $program->setTitle($programData['title']);
            $program->setSynopsis($programData['synopsis']);
            $program->setCategory($this->getReference($programData['category_reference']));
            $manager->persist($program);
            $this->addReference('program_' . $programData['reference_id'], $program);

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
