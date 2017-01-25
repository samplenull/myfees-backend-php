<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Utility;
use AppBundle\Form\UtilityType;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UtilityController
 * @package AppBundle\Controller
 */
class UtilityController extends FOSRestController
{

    /**
     * Return all utilities
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     200 = "Returned when successful",
     *     404 = "Returned when no utilities is found"
     *   }
     * )
     *
     *
     */
    public function getUtilitiesAction()
    {
        $em = $this->get('doctrine')->getManager();
        $data = $em->getRepository('AppBundle:Utility')->findAll();

        if (!$data) {
            $this->createNotFoundException('There is no utilities found');
        }
        return $this->handleView($this->view($data, 200));
    }

    /**
     * Return existing utility by id.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     200 = "Returned when successful",
     *     404 = "Returned when the utility is not found"
     *   }
     * )
     *
     *
     * @internal param int $id the utility id
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function getUtilityAction($id)
    {
        $em = $this->get('doctrine')->getManager();
        $data = $em->getRepository('AppBundle:Utility')->find($id);
        if (!$data) {
            $this->createNotFoundException('Utility does not exist');
        }
        return $this->handleView($this->view($data, 200));
    }

    public function postUtilitiesAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $utility = new Utility();
        $form = $this->createForm(UtilityType::class, $utility);
        $form->submit($data);

        if ($form->isValid()) {
            $em = $this->get('doctrine')->getManager();
            $em->persist($utility);
            $em->flush();
            return $this->handleView($this->routeRedirectView('get_utility', ['id' => $utility->getId()]));
        }
        return ['form' => $form->getErrors()]; // ?? maybe not the right return here

    }

    public function putUtilityAction($id)
    {
    }

    public function deleteUtilityAction()
    {
    }


}
