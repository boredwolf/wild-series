<?php


namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{


    const EPISODES = [
        'game_of_thrones_season_1_episode_1' => [
            'title' => 'Winter Is Coming',
            'number' => 1,
            'synopsis' => 'The first episode of Game of Thrones...',
            'season' => 'game_of_thrones_season_1',
        ],
        'game_of_thrones_season_1_episode_2' => [
            'title' => 'The Kingsroad',
            'number' => 2,
            'synopsis' => 'The second episode of Game of Thrones...',
            'season' => 'game_of_thrones_season_1',
        ],
        'game_of_thrones_season_2_episode_1' => [
            'title' => 'The North Remembers',
            'number' => 1,
            'synopsis' => 'The first episode of Game of Thrones season 2...',
            'season' => 'game_of_thrones_season_2',
        ],
        'game_of_thrones_season_2_episode_2' => [
            'title' => 'The Night Lands',
            'number' => 2,
            'synopsis' => 'The second episode of Game of Thrones season 2...',
            'season' => 'game_of_thrones_season_2',
        ],
        'breaking_bad_season_1_episode_1' => [
            'title' => 'Pilot',
            'number' => 1,
            'synopsis' => 'The pilot episode of Breaking Bad...',
            'season' => 'breaking_bad_season_1',
        ],
        'breaking_bad_season_1_episode_2' => [
            'title' => 'Cat\'s in the Bag...',
            'number' => 2,
            'synopsis' => 'The second episode of Breaking Bad season 1...',
            'season' => 'breaking_bad_season_1',
        ],
        'breaking_bad_season_2_episode_1' => [
            'title' => 'Seven Thirty-Seven',
            'number' => 1,
            'synopsis' => 'The first episode of Breaking Bad season 2...',
            'season' => 'breaking_bad_season_2',
        ],
        'breaking_bad_season_2_episode_2' => [
            'title' => 'Grilled',
            'number' => 2,
            'synopsis' => 'The second episode of Breaking Bad season 2...',
            'season' => 'breaking_bad_season_2',
        ],
        'friends_season_1_episode_1' => [
            'title' => 'The One Where Monica Gets a Roommate',
            'number' => 1,
            'synopsis' => 'The first episode of Friends...',
            'season' => 'friends_season_1',
        ],
        'friends_season_1_episode_2' => [
            'title' => 'The One with the Sonogram at the End',
            'number' => 2,
            'synopsis' => 'The second episode of Friends...',
            'season' => 'friends_season_1',
        ],
        'friends_season_2_episode_1' => [
            'title' => 'The One with Ross\'s New Girlfriend',
            'number' => 1,
            'synopsis' => 'The first episode of Friends season 2...',
            'season' => 'friends_season_2',
        ],
        'friends_season_2_episode_2' => [
            'title' => 'The One with the Breast Milk',
            'number' => 2,
            'synopsis' => 'The second episode of Friends season 2...',
            'season' => 'friends_season_2',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::EPISODES as $key => $episodeData) {
            $episode = new Episode();
            $episode->setTitle($episodeData['title']);
            $episode->setNumber($episodeData['number']);
            $episode->setSynopsis($episodeData['synopsis']);
            $episode->setSeason($this->getReference($episodeData['season']));
            $manager->persist($episode);
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
