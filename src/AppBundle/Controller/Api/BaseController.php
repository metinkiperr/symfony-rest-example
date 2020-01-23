<?php

namespace AppBundle\Controller\Api;


use AppBundle\Api\ApiProblem;
use AppBundle\Api\ApiProblemException;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;


class BaseController extends Controller
{
    /**
     * @return Logger
     */
    protected function getLogger()
    {
        return $this->getLogger();
    }

    protected function createApiResponse($data, $statusCode = 200)
    {
        $json = $this->serialize($data);

        return new Response(
            $json, $statusCode, array(
                "Content-Type" => "application/json",
            )
        );
    }

    protected function serialize($data, $format = 'json')
    {
        $context = new SerializationContext();
        $context->setSerializeNull(true);

        return $this->getSerializer()->serialize($data, $format, $context);
    }

    /**
     * @return Serializer
     */
    protected function getSerializer()
    {
        return $this->getSerializer();
    }

    protected function processForm(Request $request, FormInterface $form)
    {
        $data = json_decode($request->getContent(), true);

        if (null === $data) {
            $apiProblem = new ApiProblem(400, ApiProblem::TYPE_INVALID_REQUEST_BODY_FORMAT);
            throw new ApiProblemException($apiProblem);
        }

        $clearMissing = $request->getMethod() != "PATCH";

        $form->submit($clearMissing);

    }

    protected function getErrorsFromForm(FormInterface $form)
    {
        $errors = array();

        foreach ($form->getErrors() as $error) {

            $errors[] =$error->getMessage();

        }

        foreach ($form->all() as $childForm){
            if ($childForm instanceof FormInterface){
                if ($childErrors = $this->getErrorsFromForm($childForm)){
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }
        return $errors;
    }

    protected function throwApiProblemValidationException(FormInterface $form){
        $errors = $this->getErrorsFromForm($form);
        $apiProblem = new ApiProblem(
            400,
            ApiProblem::TYPE_VALIDATION_ERROR
        );
        $apiProblem->set('errors', $errors);

        throw new ApiProblemException($apiProblem);
    }


}