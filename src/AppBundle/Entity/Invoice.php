<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Invoice
 *
 * @ORM\Table(name="invoice")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InvoiceRepository")
 */
class Invoice
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
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="decimal", precision=7, scale=3)
     */
    private $value;

    /**
     * @var Utility
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Utility", inversedBy="invoices")
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Invoice
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
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
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



}

