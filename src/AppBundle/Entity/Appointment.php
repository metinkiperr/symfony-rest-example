<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repositories\AppointmentRepository")
 * @ORM\Table(name="appointment")
 */
class Appointment
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $appointmentId;

    /**
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="appointments")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="customer_id")
     */
    private $customer;

    /** @ORM\Column(type="datetime") */
    private $appointmentDate;

    /** @ORM\Column(type="text") */
    private $appointmentNotes;

    /**
     * Get appointmentId
     *
     * @return integer
     */
    public function getAppointmentId()
    {
        return $this->appointmentId;
    }

    /**
     * Get appointmentDate
     *
     * @return \DateTime
     */
    public function getAppointmentDate()
    {
        return $this->appointmentDate;
    }

    /**
     * Set appointmentDate
     *
     * @param \DateTime $appointmentDate
     *
     * @return Appointment
     */
    public function setAppointmentDate($appointmentDate)
    {
        $this->appointmentDate = $appointmentDate;

        return $this;
    }

    /**
     * Get appointmentNotes
     *
     * @return string
     */
    public function getAppointmentNotes()
    {
        return $this->appointmentNotes;
    }

    /**
     * Set appointmentNotes
     *
     * @param string $appointmentNotes
     *
     * @return Appointment
     */
    public function setAppointmentNotes($appointmentNotes)
    {
        $this->appointmentNotes = $appointmentNotes;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \AppBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set customer
     *
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return Appointment
     */
    public function setCustomer(\AppBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }
}
