<?php

namespace AppBundle\Controller\Api;

use AppBundle\Services\CustomerService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Customer;


class CustomerController extends BaseController
{

    protected $type = '\AppBundle\Form\CustomerType';
    protected $service;

    public function __construct(CustomerService $customerService)
    {
        $this->service = $customerService;
    }

    /**
     * @Route("/api/customers", name="customer_create")
     * @Method("POST")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $customer = new Customer();
        $form = $this->createForm($this->type, $customer);
        $form->submit($request->request->all());
        if (!$form->isValid()) {
            $this->throwApiProblemValidationException($form);
        }
        $this->service->createCustomer($customer);
        $response = $this->createApiResponse($customer, 201);

        $response->headers->set(
            'Location',
            $this->generateUrl(
                'customers_read',
                ['id' => $customer->getCustomerId()]
            )
        );

        return $response;
    }


    /**
     * @Route("/api/customers", name="customers_list")
     * @Method("GET")
     * @param Request $request Sent request
     * @return Response
     *
     */
    public function listAction(Request $request)
    {
        $customers = $this->service->getAllCustomers();

        $response = $this->createApiResponse(['items' => $customers], 200);

        return $response;
    }


    /**
     * @Route("/api/customers/{id}", name="customers_read")
     * @Method("GET")
     *
     * @param integer $id customer_name
     * @return Response
     *
     */
    public function showAction($id)
    {
        $customer = $this->service->getOneCustomer($id);

        if (!$customer) {
            throw $this->createNotFoundException("Customer with id ".$id." couldn't found.");
        }

        $response = $this->createApiResponse($customer, 200);

        return $response;
    }


    /**
     * @Route("/api/customers/{id}", name="customers_update")
     * @Method({"PUT", "PATCH"})
     *
     * @param integer $id customer id
     * @param Request $request Sent request
     * @return Response
     */
    public function updateAction($id, Request $request)
    {
        $customer = $this->service->getOneCustomer($id);

        if (!$customer) {
            throw $this->createNotFoundException("Customer with unique id ".$id." couldn't found.");
        }

        $form = $this->createForm($this->type, $customer);
        $this->processForm($request, $form);

        if (!$form->isValid()) {
            $this->throwApiProblemValidationException($form);
        }
        $this->service->updateCustomer($customer);

        $response = $this->createApiResponse($customer, 200);

        return $response;
    }


    /**
     * @Route("/api/customers/{id}", name="customer_delete")
     * @Method("DELETE")
     *
     * @param integer $id Customer id
     * @return Response
     *
     */
    public function deleteAction($id)
    {
        $customer = $this->service->getOneCustomer($id);
        if ($customer) {
            $this->service->deleteCustomer($customer);
        }

        return $this->createApiResponse(null, 204);
    }


}
