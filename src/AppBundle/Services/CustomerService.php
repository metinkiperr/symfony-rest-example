<?php
namespace AppBundle\Services;
use AppBundle\Repositories\CustomerRepository;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Customer;

class CustomerService
{
    private $em;
    const ENTITY_NAME ="AppBundle:Customer";
    public function __construct(EntityManager $entityManager)
    {
        $this->em=$entityManager;
    }

    public function getAllCustomers()
    {
        return $this->em->getRepository(self::ENTITY_NAME)->findAll();
    }

    public function getOneCustomer($customerId)
    {
        return $this->em->getRepository(self::ENTITY_NAME)->find($customerId);
    }

    public function createCustomer(Customer $customer)
    {
        $this->em->persist($customer);
        $this->em->flush();
    }

    public function updateCustomer(Customer $customer)
    {
        $customer =$this->em->getRepository(self::ENTITY_NAME)->find($customer);
        $this->em->persist($customer);
        $this->em->flush();

    }

    public function deleteCustomer(Customer $customer)
    {
        $customer =$this->em->getRepository(self::ENTITY_NAME)->find($customer);
        $this->em->remove($customer);
        $this->em->flush();
    }
}