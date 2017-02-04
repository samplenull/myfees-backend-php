<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Utility;
use AppBundle\Form\UtilityType;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class UtilityController
 * @package AppBundle\Controller
 */
class UtilityController extends FOSRestController
{
    const RESOURCE_ENTITY_ALIAS = 'AppBundle:Utility';

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
     * @return Response
     */
    public function getUtilitiesAction()
    {
        $em = $this->get('doctrine')->getManager();
        $data = $em->getRepository(self::RESOURCE_ENTITY_ALIAS)->findAll();

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
     * @return Response
     *
     */
    public function getUtilityAction($id)
    {
        $em = $this->get('doctrine')->getManager();
        $data = $em->getRepository(self::RESOURCE_ENTITY_ALIAS)->find($id);
        if (!$data) {
            $this->createNotFoundException('Utility does not exist');
        }
        return $this->handleView($this->view($data, 200));
    }
    /**
     * Creates a new utility from the submitted JSON data.
     *
     * @ApiDoc(
     *    resource = true,
     *    input = "AppBundle\Form\UtilityType",
     *    statusCodes = {
     *      200 = "Returned when successful",
     *      400 = "Returned when the form has errors"
     *    }
     * )
     * @param Request $request
     * @return Response|BadRequestHttpException
     *
     */
    public function postUtilitiesAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $item = new Utility();
        $form = $this->createForm(UtilityType::class, $item);
        $form->submit($data);

        if ($form->isValid()) {
            $em = $this->get('doctrine')->getManager();
            $em->persist($item);
            $em->flush();
            return $this->handleView(
                $this->routeRedirectView('get_utility', ['id' => $item->getId()])
            );
        }
        return new BadRequestHttpException('Bad parameters for request');
    }

    /**
     *
     * Update existing note from the submitted data or create a new note at a specific location.
     *
     * @ApiDoc(
     *    resource = true,
     *    input = "AppBundle\Form\UtilityType",
     *    statusCodes = {
     *      201 = "Returned when a new resource is created",
     *      204 = "Returned when successful",
     *      400 = "Returned when the form has errors"
     *    }
     * )
     *
     * @param Request $request
     * @param $id
     * @return Response|BadRequestHttpException
     */
    public function putUtilityAction(Request $request, $id)
    {
        $data = json_decode($request->getContent(), true);
        $em = $this->get('doctrine')->getManager();
        $item = $em->find(self::RESOURCE_ENTITY_ALIAS, $id);
        if (null === $item) {
            $item = new Utility();
            // assigning id is not possible for IDENTITY id-field strategy
            $item->setId($id);
            $statusCode = Response::HTTP_CREATED;
        } else {
            $statusCode = Response::HTTP_NO_CONTENT;
        }

        $form = $this->createForm(UtilityType::class, $item);
        $form->submit($data);

        if ($form->isValid()) {

            $em->persist($item);
            $em->flush();
            return $this->handleView(
                $this->routeRedirectView('get_utility', ['id' => $item->getId()], $statusCode)
            );
        }
        return new BadRequestHttpException('Bad parameters for request');
    }

    /**
     * Removes utility
     *
     * @ApiDoc(
     *    resource = true,
     *    statusCodes = {
     *      204 = "Returned when successful",
     *      400 = "Returned when the form has errors",
     *      404 = "Returned when item not found"
     *    }
     * )
     *
     * @param $id
     * @return Response
     */
    public function deleteUtilityAction($id)
    {
        $em = $this->get('doctrine')->getManager();
        $item = $em->find(self::RESOURCE_ENTITY_ALIAS, $id);
        $statusCode = $item === null ? Response::HTTP_NOT_FOUND : Response::HTTP_NO_CONTENT;
        $em->remove($item);
        $em->flush();
        return $this->handleView(
            $this->routeRedirectView('get_utilities', [], $statusCode)
        );
    }


}
