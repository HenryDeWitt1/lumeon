<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Doctor;
use AppBundle\Entity\Patient;
use AppBundle\Form\Type\PatientType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/doctor/")
 */
class DoctorController extends Controller
{
    /**
     * @Route("{id}/{patientId}")
     * @ParamConverter("patient", options={"mapping": {"patientId": "id"}})
     *
     * @param Doctor $doctor
     * @param Patient $patient
     * @return Response
     */
    public function addExistingPatient(Doctor $doctor,Patient $patient){

        $doctor->addPatient($patient);
        $this->getDoctrine()->getManager()->persist($doctor);
        $this->getDoctrine()->getManager()->flush();

        $serializer = $this->get('jms_serializer');

        $response =  new Response(
            $serializer->serialize([
                'doctor'=>$doctor,
                'patients'=>$doctor->getPatients(),
                'msg'=>'patient successfully assigned to doctor'
            ], 'json')
        );
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("{id}")
     *
     * @param Doctor $doctor
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function addNewPatient(Doctor $doctor,Request $request){

        $form = $this->createForm(PatientType::class,New Patient());
        $form->handleRequest($request);

        if($form->isValid()){

            /** @var Patient $patient */
            $patient = $form->getData();

            $doctor->addPatient($patient);
            $this->getDoctrine()->getManager()->persist($doctor);
            $this->getDoctrine()->getManager()->flush();

            $serializer = $this->get('jms_serializer');

            $response =  new Response(
                $serializer->serialize([
                    'doctor'=>$doctor,
                    'patients'=>$doctor->getPatients(),
                    'msg'=>'patient successfully assigned to doctor'
                ], 'json')
            );
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }else{
            return new JsonResponse([
                'msg'=>'Error with patient data',
                'errors'=>$form->getErrors(true)
            ]);
        }

    }
}