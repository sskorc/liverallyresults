<?php

namespace AppBundle\DataFixtures\MongoDB;

use AppBundle\Document\Crew;
use AppBundle\Document\CrewMember;
use AppBundle\Document\Rally;
use AppBundle\Document\Stage;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadRallyData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $rally = new Rally('1. Rally Schibsted', new \DateTime('2015-07-27T14:00:00Z'), new \DateTime('2015-07-28T23:00:00Z'));
        $rally->addStage(new Stage(1, 'Hopy 1', new \DateTime('2015-07-27T16:21:00Z'), 8.28));

        $crew = new Crew(1, new CrewMember('Tomasz', 'Kuchar', 'POL'), new CrewMember('Daniel', 'Dymurski', 'POL'), 'Peugeot 207 S2000', '2');

        $manager->persist($crew);

        $rally->addCrew($crew);
        $manager->persist($rally);
        $manager->flush();
    }
}
