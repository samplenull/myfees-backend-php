<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

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


}
