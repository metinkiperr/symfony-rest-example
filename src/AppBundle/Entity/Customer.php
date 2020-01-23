<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity
 * @ORM\Table(name="customer")
 * @Serializer\ExclusionPolicy("none")
 */
class Customer{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $customerId;

    /** @ORM\Column(type="string", length=64) */
    private $customerName;

    /** @ORM\Column(type="string",length=16) */
    private $customerContactNumber;

    /**
     * @Serializer\Exclude()
     * @ORM\OneToMany(targetEntity="Appointment", mappedBy="customer")
     */
    private $appointments;

    public function __construct() {
        $this->appointments = new ArrayCollection();
    }

    /**
     * Get customerId
     *
     * @return integer
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Set customerName
     *
     * @param string $customerName
     *
     * @return Customer
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;

        return $this;
    }

    /**
     * Get customerName
     *
     * @return string
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * Set customerContactNumber
     *
     * @param string $customerContactNumber
     *
     * @return Customer
     */
    public function setCustomerContactNumber($customerContactNumber)
    {
        $this->customerContactNumber = $customerContactNumber;

        return $this;
    }

    /**
     * Get customerContactNumber
     *
     * @return string
     */
    public function getCustomerContactNumber()
    {
        return $this->customerContactNumber;
    }

    /**
     * Add appointment
     *
     * @param \AppBundle\Entity\Appointment $appointment
     *
     * @return Customer
     */
    public function addAppointment(\AppBundle\Entity\Appointment $appointment)
    {
        $this->appointments[] = $appointment;

        return $this;
    }

    /**
     * Remove appointment
     *
     * @param \AppBundle\Entity\Appointment $appointment
     */
    public function removeAppointment(\AppBundle\Entity\Appointment $appointment)
    {
        $this->appointments->removeElement($appointment);
    }

    /**
     * Get appointments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAppointments()
    {
        return $this->appointments;
    }
}
