<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as JMS;

/**
 * @MongoDB\EmbeddedDocument
 */
class Stage
{
    /**
     * @MongoDB\Id(strategy="none")
     */
    protected $number;

    /**
     * @MongoDB\String
     */
    protected $name;

    /**
     * @MongoDB\Date
     * @JMS\SerializedName("startTime")
     */
    protected $startTime;

    /**
     * @MongoDB\Float
     */
    protected $distance;

    public function __construct($number, $name, $startTime, $distance)
    {
        $this->number = $number;
        $this->name = $name;
        $this->startTime = $startTime;
        $this->distance = $distance;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @return float
     */
    public function getDistance()
    {
        return $this->distance;
    }
}
