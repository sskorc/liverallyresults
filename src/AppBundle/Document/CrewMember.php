<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as JMS;

/**
 * @MongoDB\EmbeddedDocument
 */
class CrewMember
{
    /**
     * @MongoDB\Id(strategy="auto")
     * @JMS\Exclude
     */
    protected $id;

    /**
     * @MongoDB\String
     * @JMS\SerializedName("firstName")
     */
    protected $firstName;

    /**
     * @MongoDB\String
     * @JMS\SerializedName("lastName")
     */
    protected $lastName;

    /**
     * @MongoDB\String
     */
    protected $nationality;

    public function __construct($firstName, $lastName, $nationality)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->nationality = $nationality;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getNationality()
    {
        return $this->nationality;
    }
}
