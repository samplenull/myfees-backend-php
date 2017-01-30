<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JsonSerializable;

/**
 * Utility
 *
 * @ORM\Table(name="utility")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UtilityRepository")
 */
class Utility implements JsonSerializable
{

    const DATE_FORMAT = 'd.m.Y H:i:s';
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var UtilityRate[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UtilityRate", mappedBy="utility")
     * @Exclude
     */
    private $rates;

    /**
     * @var Invoice[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Invoice", mappedBy="utility")
     * @Exclude
     */
    private $invoices;

    /**
     * @var Invoice[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Reading", mappedBy="utility")
     * @Exclude
     */
    private $readings;


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
     * Set name
     *
     * @param string $name
     *
     * @return Utility
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return UtilityRate[]
     */
    public function getRates()
    {
        return $this->rates;
    }

    /**
     * @param UtilityRate[] $rates
     */
    public function setRates($rates)
    {
        $this->rates = $rates;
    }

    /**
     * @return Invoice[]
     */
    public function getInvoices()
    {
        return $this->invoices;
    }

    /**
     * @param Invoice[] $invoices
     */
    public function setInvoices($invoices)
    {
        $this->invoices = $invoices;
    }

    /**
     * @return Invoice[]
     */
    public function getReadings()
    {
        return $this->readings;
    }

    /**
     * @param Invoice[] $readings
     */
    public function setReadings($readings)
    {
        $this->readings = $readings;
    }


    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName()
        ];
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

}

