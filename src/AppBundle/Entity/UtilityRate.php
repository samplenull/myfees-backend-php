<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UtilityRate
 *
 * @ORM\Table(name="utility_rate")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UtilityRateRepository")
 */
class UtilityRate implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startDate", type="date", nullable=true)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="date", nullable=true)
     */
    private $endDate;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="decimal", precision=7, scale=3)
     */
    private $value;


    /**
     * @var Utility
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Utility", inversedBy="rates")
     */
    private $utility;



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return UtilityRate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return UtilityRate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return UtilityRate
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return Utility
     */
    public function getUtility()
    {
        return $this->utility;
    }

    /**
     * @param Utility $utility
     */
    public function setUtility($utility)
    {
        $this->utility = $utility;
    }

    function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'start_date' => $this->startDate->format(Utility::DATE_FORMAT),
            'end_date' => $this->endDate->format(Utility::DATE_FORMAT),
            'value' => $this->value,
            'utility_id' => $this->getUtility()->getId()
        ];
    }


}

