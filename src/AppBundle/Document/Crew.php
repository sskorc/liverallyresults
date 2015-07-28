<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as JMS;

/**
 * @MongoDB\Document
 */
class Crew
{
    /**
     * @MongoDB\Id(strategy="none")
     */
    protected $number;

    /**
     * @MongoDB\EmbedMany(targetDocument="AppBundle\Document\CrewMember")
     */
    protected $driver;

    /**
     * @MongoDB\EmbedMany(targetDocument="AppBundle\Document\CrewMember")
     * @JMS\SerializedName("coDriver")
     */
    protected $coDriver;

    /**
     * @MongoDB\String
     */
    protected $car;

    /**
     * @MongoDB\String
     */
    protected $group;

    public function __construct($number, $driver, $coDriver, $car, $group)
    {
        $this->number = $number;
        $this->driver = $driver;
        $this->coDriver = $coDriver;
        $this->car = $car;
        $this->group = $group;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return Participant
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @return Participant
     */
    public function getCoDriver()
    {
        return $this->coDriver;
    }

    /**
     * @return string
     */
    public function getCar()
    {
        return $this->car;
    }

    /**
     * @return string
     */
    public function getGroup()
    {
        return $this->group;
    }
}
