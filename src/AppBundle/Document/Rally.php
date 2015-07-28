<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as JMS;

/**
 * @MongoDB\Document
 */
class Rally
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $name;

    /**
     * @MongoDB\Date
     * @JMS\SerializedName("startDate")
     */
    protected $startDate;

    /**
     * @MongoDB\Date
     * @JMS\SerializedName("endDate")
     */
    protected $endDate;

    /**
     * @MongoDB\EmbedMany(targetDocument="AppBundle\Document\Stage")
     * @JMS\Exclude
     */
    protected $stages;

    /**
     * @MongoDB\ReferenceMany(targetDocument="AppBundle\Document\Crew")
     * @JMS\Exclude
     */
    protected $crews;

    /**
     * @param string $name
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     */
    public function __construct($name, $startDate, $endDate)
    {
        $this->name = $name;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->stages = array();
        $this->crews = new \Doctrine\Common\Collections\ArrayCollection;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    public function addStage(Stage $stage)
    {
        $this->stages[$stage->getNumber()] = $stage;
    }

    public function getStages()
    {
        return $this->stages;
    }

    public function getStageByNumber($number)
    {
        return $this->stages[$number-1];
    }

    public function updateStage($stage)
    {
        $this->stages[$stage->getNumber()] = $stage;
    }

    public function addCrew(Crew $crew)
    {
        $this->crews[] = $crew;
    }

    public function getCrews()
    {
        return $this->crews;
    }

    public function getCrewByNumber($number)
    {
        foreach ($this->crews as $crew) {
            if ($crew->getNumber() == $number) {
                return $crew;
            }
        }

        return null;
    }
}
