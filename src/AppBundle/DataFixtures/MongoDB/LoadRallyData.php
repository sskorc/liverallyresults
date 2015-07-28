<?php

namespace AppBundle\DataFixtures\MongoDB;

use AppBundle\Document\Crew;
use AppBundle\Document\CrewMember;
use AppBundle\Document\Rally;
use AppBundle\Document\Stage;
use AppBundle\Document\StageResult;
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

        $crew1 = new Crew(1, new CrewMember('Kajetan', 'Kajetanowicz', 'POL'), new CrewMember('Jarek', 'Baran', 'POL'), 'Ford Fiesta R5', '2');
        $manager->persist($crew1);
        $rally->addCrew($crew1);

        $crew2 = new Crew(2, new CrewMember('Tomasz', 'Kuchar', 'POL'), new CrewMember('Daniel', 'Dymurski', 'POL'), 'Peugeot 207 S2000', '2');
        $manager->persist($crew2);
        $rally->addCrew($crew2);

        $crew3 = new Crew(3, new CrewMember('Lukasz', 'Habaj', 'POL'), new CrewMember('Piotr', 'Wos', 'POL'), 'Mitsubishi Lancer Evo IX', '3');
        $manager->persist($crew3);
        $rally->addCrew($crew3);

        $crew4 = new Crew(14, new CrewMember('Robert', 'Kubica', 'POL'), new CrewMember('Maciej', 'Szepaniak', 'POL'), 'Ford Fiesta RS WRC', 'WRC');
        $manager->persist($crew4);
        $rally->addCrew($crew4);

        $stage = new Stage(1, 'Hopy 1', new \DateTime('2015-07-27T16:21:00Z'), 8.28);
        $stage->addResult(new StageResult($crew1, 310400, 0));     //2
        $stage->addResult(new StageResult($crew2, 315800, 10000)); //4
        $stage->addResult(new StageResult($crew3, 316000, 0)); //3
        $stage->addResult(new StageResult($crew4, 302300, 0)); //1

        $rally->addStage($stage);
        $rally->addStage(new Stage(2, 'Kosowo 1', new \DateTime('2015-07-27T18:15:00Z'), 12.71));
        $rally->addStage(new Stage(3, 'Hopy 2', new \DateTime('2015-07-28T10:09:00Z'), 8.28));
        $rally->addStage(new Stage(4, 'Kosowo 2', new \DateTime('2015-07-28T12:03:00Z'), 12.71));

        $manager->persist($rally);
        $manager->flush();
    }
}
