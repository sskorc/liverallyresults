<?php

namespace AppBundle\DataFixtures\MongoDB;

use AppBundle\Document\Rally;
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

        $manager->persist($rally);
        $manager->flush();
    }
}
