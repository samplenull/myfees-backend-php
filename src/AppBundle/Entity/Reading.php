<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reading
 *
 * @ORM\Table(name="reading")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReadingRepository")
 */
class Reading
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
     * @var int
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var Utility
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Utility", inversedBy="readings")
     */
    private $utility;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

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
     * Set value
     *
     * @param integer $value
     *
     * @return Reading
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Reading
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
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

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }


}

