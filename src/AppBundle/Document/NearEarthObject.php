<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document()
 * @MongoDB\Document(repositoryClass="AppBundle\Repository\NearEarthObjectRepository")
 */
class NearEarthObject
{
    /**
     * @var int
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @var \DateTime
     * @MongoDB\Field(type="date")
     */
    protected $date;

    /**
     * @var int
     * @MongoDB\Field(type="int")
     */
    protected $reference;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $name;

    /**
     * @var float
     * @MongoDB\Field(type="float")
     */
    protected $speed;

    /**
     * @var bool
     * @MongoDB\Field(type="bool")
     */
    protected $isHazardous;

    public static function fromArray($item)
    {
        return (new self())
            ->setDate($item['close_approach_data'][0]['close_approach_date'] ?? null)
            ->setReference($item['neo_reference_id'] ?? null)
            ->setName($item['name'] ?? null)
            ->setSpeed($item['close_approach_data'][0]['relative_velocity']['kilometers_per_hour'] ?? null)
            ->setIsHazardous($item['is_potentially_hazardous_asteroid'] ?? null)
        ;
    }

    /**
     * Get id
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime $date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set reference
     *
     * @param int $reference
     * @return $this
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return int $reference
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set speed
     *
     * @param float $speed
     * @return $this
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;

        return $this;
    }

    /**
     * Get speed
     *
     * @return float $speed
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * Set isHazardous
     *
     * @param bool $isHazardous
     * @return $this
     */
    public function setIsHazardous($isHazardous)
    {
        $this->isHazardous = $isHazardous;

        return $this;
    }

    /**
     * Get isHazardous
     *
     * @return bool $isHazardous
     */
    public function getIsHazardous()
    {
        return $this->isHazardous;
    }
}
