<?php


namespace AppBundle\Repositories;


use AppBundle\Entity\Appointment;
use AppBundle\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;


/**
 * Class AppointmentRepository
 * @package AppBundle\Repositories
 */
class AppointmentRepository
{

    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository =$entityManager->getRepository(Appointment::class);
    }

    public function find($appointment)
    {
        return $this->repository->find($appointment);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

   }