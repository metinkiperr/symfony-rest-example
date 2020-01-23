<?php

namespace AppBundle\Controller\Api;


use AppBundle\Services\AppointmentService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Appointment;


class AppointmentController extends BaseController
{

    protected $type = '\AppBundle\Form\AppointmentType';
    protected $service;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->service =$appointmentService;
    }
    /**
     * @Route("/api/customers/{id}/appointments", name="appointment_create")
     * @Method("POST")
     *
     * @param integer $id customer id
     * @param Request $request
     * @return Response
     */
    public function newAction($id, Request $request)
    {

        $appointment = new Appointment();
        $form = $this->createForm($this->type, $appointment);
        $this->processForm($request, $form);

        if (!$form->isValid()){
            $this->throwApiProblemValidationException($form);
        }
        $this->service->createAppointment($id);
        $response = $this->createApiResponse($appointment, 201);
        $response->headers->set(
            'Location',
            $this->generateUrl(
                'appointments_read',
                ['id' => $appointment->getAppointmentId()]
            )
        );
        return $response;
    }


    /**
     * @Route("/api/appointments", name="appointments_list")
     * @Method("GET")
     * @param Request $request Sent request
     * @return Response
     *
     */
    public function listAction(Request $request)
    {
        $appointments=$this->service->getAppointments();

        $response = $this->createApiResponse(['items' => $appointments], 200);
        return $response;
    }


    /**
     * @Route("/api/appointments/{id}", name="appointments_read")
     * @Method("GET")
     *
     * @param integer $id appointment_name
     * @return Response
     *
     */
    public function showAction($id)
    {
        $appointment=$this->service->getOneAppointment($id);

        if (!$appointment) {
            throw $this->createNotFoundException("appointment with id " . $id . " couldn't found.");
        }

        $response = $this->createApiResponse($appointment, 200);
        return $response;
    }


    /**
     * @Route("/api/appointments/{id}", name="appointments_update")
     * @Method({"PUT", "PATCH"})
     *
     * @param integer $id appointment id
     * @param Request $request Sent request
     * @return Response
     */
    public function updateAction($id, Request $request)
    {

        $appointment=$this->service->getOneAppointment($id);

        if (!$appointment) {
            throw $this->createNotFoundException("appointment with unique id " . $id . " couldn't found.");
        }

        $form = $this->createForm($this->type, $appointment);
        $this->processForm($request, $form);

        if (!$form->isValid()){
            $this->throwApiProblemValidationException($form);
        }
        $this->service->updateAppointment($id);
        $response = $this->createApiResponse($appointment, 200);
        return $response;
    }


    /**
     * @Route("/api/appointments/{id}", name="appointment_delete")
     * @Method("DELETE")
     *
     * @param integer $id appointment id
     * @return Response
     *
     */
    public function deleteAction($id)
    {
        $appointment =$this->service->getOneAppointment($id);

        if ($appointment){
           $this->service->deleteAppointment($id);
        }

        return $this->createApiResponse(null, 204);
    }

}