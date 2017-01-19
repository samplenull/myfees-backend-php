<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations;

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
     * @return JsonResponse
     * @internal param int $id the utility id
     *
     */
    public function getUtilitiesAction()
    {
        $em = $this->get('doctrine')->getManager();
            $response = $em->getRepository('AppBundle:Utility')->findAll();

        if (!$response) {
            $this->createNotFoundException('There is no utilities found');
        }
        return new JsonResponse($response);
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
     *  @Annotations\QueryParam(name="id", requirements="\d+", nullable=true, description="id of specific note")
     *
     * @return JsonResponse
     * @internal param int $id the utility id
     *
     */
    public function getUtilityAction($id)
    {
        $em = $this->get('doctrine')->getManager();
        $response = $em->getRepository('AppBundle:Utility')->find($id);
        if (!$response) {
            $this->createNotFoundException('Utility does not exist');
        }
        return new JsonResponse($response);
    }




}
