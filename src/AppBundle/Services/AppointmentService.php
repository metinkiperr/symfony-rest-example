<?php

namespace AppBundle\Services;

use AppBundle\Entity\Appointment;
use Doctrine\ORM\EntityManager;

class AppointmentService
{
    private $em;
    const ENTITY_NAME="AppBundle:Appointment";
    /**
     * AppointmentService constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getAppointments()
    {
        return $this->em->getRepository(self::ENTITY_NAME)->findAll();
    }

    public function getOneAppointment($appointmentId)
    {
        return $this->em->getRepository(self::ENTITY_NAME)->find($appointmentId);
    }

    public function createAppointment(Appointment $appointment,$id)
    {    $appointment = new Appointment();
        $customer =$this->em->find("AppBundle:Customer",$id);
        $appointment->setCustomer($customer);
        $this->em->persist($appointment);
        $this->em->flush();
    }

    public function updateAppointment($id)
    {
        $appointment =$this->em->find("AppBundle:Appointment",$id);

        $this->em->persist($appointment);
        $this->em->flush();
    }

    public function deleteAppointment($id)
    {
        $appointment=$this->em->find("AppBundle:Appointment",$id);

        $this->em->remove($appointment);

        $this->em->flush();
    }
    
}