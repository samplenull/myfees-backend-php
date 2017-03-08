<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Reading;
use AppBundle\Entity\Utility;
use AppBundle\Form\ReadingType;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class UtilityReadingController
 * @package AppBundle\Controller
 */
class UtilityReadingController extends FOSRestController
{
    protected const RESOURCE_ENTITY_ALIAS = 'AppBundle:Reading';
    protected const ROUTE_GET_UTILITY_RESOURCES = 'api_get_utility_readings';
    protected const ROUTE_GET_UTILITY_RESOURCE = 'api_get_utility_reading';

    /**
     * Return all readings for specified utility
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     200 = "Returned when successful",
     *     404 = "Returned when no readings is found"
     *   }
     * )
     *
     * @param $utility_id
     * @return Response
     */
    public function getReadingsAction($utility_id)
    {
        $em = $this->get('doctrine')->getManager();
        $data = $em->getRepository(self::RESOURCE_ENTITY_ALIAS)->findBy(['utility' => $utility_id]);

        if (!$data) {
            $this->createNotFoundException('Nothing found');
        }
        return $this->handleView($this->view($data, 200));
    }

    /**
     * Return existing resource by id.
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
     * @param $utility_id
     * @param $id
     * @return Response
     */
    public function getReadingAction($utility_id, $id)
    {
        $em = $this->get('doctrine')->getManager();
        $data = $em->getRepository(self::RESOURCE_ENTITY_ALIAS)->findOneBy(['id' => $id]);
        if (!$data) {
            $this->createNotFoundException('Resource does not exist');
        }
        return $this->handleView($this->view($data, 200));
    }

    /**
     * Creates a new utility from the submitted JSON data.
     *
     * @ApiDoc(
     *    resource = true,
     *    input = "AppBundle\Form\UtilityReadingType",
     *    statusCodes = {
     *      200 = "Returned when successful",
     *      400 = "Returned when the form has errors"
     *    }
     * )
     * @param Request $request
     * @param $utility_id
     * @return Response|BadRequestHttpException
     */
    public function postReadingsAction(Request $request, $utility_id)
    {
        $data = json_decode($request->getContent(), true);
        $item = new Reading();
        $em = $this->get('doctrine')->getManager();
        /** @var Utility $utility */
        $utility = $em->find('AppBundle:Utility', $utility_id);
        $utility->addReading($item);
        $form = $this->createForm($this->getFormClass(), $item);
        $form->submit($data);

        if ($form->isValid()) {
            $em->persist($item);
            $em->flush();
            return $this->handleView(
                $this->routeRedirectView(self::ROUTE_GET_UTILITY_RESOURCE,
                    [
                        'utility_id' => $utility->getId(),
                        'id' => $item->getId()
                    ])
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
     *    input = "AppBundle\Form\UtilityReadingType",
     *    statusCodes = {
     *      201 = "Returned when a new resource is created",
     *      204 = "Returned when successful",
     *      400 = "Returned when the form has errors"
     *    }
     * )
     *
     * @param Request $request
     * @param $id
     * @param $utility_id
     * @return Response|BadRequestHttpException
     */
    public function putReadingAction(Request $request, $utility_id, $id)
    {
        $data = json_decode($request->getContent(), true);
        $em = $this->get('doctrine')->getManager();
        /** @var Utility $utility */
        $utility = $em->find('AppBundle:Utility', $utility_id);
        /** @var Reading $item */
        $item = $em->find(self::RESOURCE_ENTITY_ALIAS, $id);

        if (null === $item) {
            $item = new Reading;
            // assigning id is not possible for IDENTITY id-field strategy
            // $item->setId($id);
            $statusCode = Response::HTTP_CREATED;
            $utility->addReading($item);
        } else {
            $statusCode = Response::HTTP_NO_CONTENT;
            $item->setUtility($utility);
        }

        $form = $this->createForm($this->getFormClass(), $item);
        $form->submit($data);

        if ($form->isValid()) {
            $em->persist($item);
            $em->flush();
            return $this->handleView(
                $this->routeRedirectView(self::ROUTE_GET_UTILITY_RESOURCE,
                    [
                        'utility_id' => $utility->getId(),
                        'id' => $item->getId()
                    ], $statusCode)
            );
        }
        return new BadRequestHttpException('Bad parameters for request');
    }

    /**
     * Removes reading
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
     * @param $utility_id
     * @param $id
     * @return Response
     */
    public function deleteReadingAction($utility_id, $id)
    {
        $em = $this->get('doctrine')->getManager();
        $item = $em->find(self::RESOURCE_ENTITY_ALIAS, $id);
        /** @var Utility $utility */
        $utility = $em->find('AppBundle:Utility', $utility_id);
        if ($item === null) {
            $statusCode = Response::HTTP_NOT_FOUND;
        } else {
            $em->remove($item);
            $em->flush();
            $statusCode = Response::HTTP_NO_CONTENT;
        }
        return $this->handleView(
            $this->routeRedirectView(self::ROUTE_GET_UTILITY_RESOURCES,
                [
                    'utility_id' => $utility->getId(),
                ], $statusCode)
        );
    }

    /**
     * @return mixed
     */
    protected function getFormClass()
    {
        return ReadingType::class;
    }
}
