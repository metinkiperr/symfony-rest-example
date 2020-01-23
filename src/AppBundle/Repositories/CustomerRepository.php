<?php

namespace AppBundle\Repositories;

use AppBundle\AppBundle;
use AppBundle\Entity\Customer;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Metadata\ClassMetadata;

class CustomerRepository
{
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository =$entityManager->getRepository(Customer::class);
    }

    public function find($customer)
    {
        return $this->repository->find($customer);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

}