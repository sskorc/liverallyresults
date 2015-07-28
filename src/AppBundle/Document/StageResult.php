<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as JMS;

/**
 * @MongoDB\EmbeddedDocument
 */
class StageResult
{
    /**
     * @MongoDB\Id(strategy="auto")
     * @JMS\Exclude
     */
    protected $id;

    /**
     * @MongoDB\Integer
     */
    protected $position;

    /**
     * @MongoDB\ReferenceOne(targetDocument="AppBundle\Document\Crew")
     */
    protected $crew;

    /**
     * @MongoDB\Integer
     */
    protected $time;

    /**
     * @MongoDB\Integer
     */
    protected $penalty;

    /**
     * @MongoDB\Integer
     */
    protected $timeAndPenalty;

    /**
     * @MongoDB\Integer
     */
    protected $diffPrevious;

    /**
     * @MongoDB\Integer
     */
    protected $diffFirst;

    function __construct($crew, $time, $penalty)
    {
        $this->crew = $crew;
        $this->time = $time;
        $this->penalty = $penalty;

        $this->timeAndPenalty = $time + $penalty;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @param mixed $diffPrevious
     */
    public function setDiffPrevious($diffPrevious)
    {
        $this->diffPrevious = $diffPrevious;
    }

    /**
     * @param mixed $diffFirst
     */
    public function setDiffFirst($diffFirst)
    {
        $this->diffFirst = $diffFirst;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position + 1;
    }

    /**
     * @return mixed
     */
    public function getCrew()
    {
        return $this->crew;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return mixed
     */
    public function getPenalty()
    {
        return $this->penalty;
    }

    /**
     * @return mixed
     */
    public function getTimeAndPenalty()
    {
        return $this->timeAndPenalty;
    }

    /**
     * @return mixed
     */
    public function getDiffPrevious()
    {
        return $this->diffPrevious;
    }

    /**
     * @return mixed
     */
    public function getDiffFirst()
    {
        return $this->diffFirst;
    }
}
