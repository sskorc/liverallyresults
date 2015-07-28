<?php

namespace AppBundle\Controller;

use AppBundle\Document\Rally;
use AppBundle\Document\Stage;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RallyController extends FOSRestController
{
    public function getRallyAction($id)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $rally = $dm->getRepository('AppBundle:Rally')->findOneById($id);

        if (empty($rally)) {
            throw new HttpException(400, 'Cannot find rally');
        }

        $view = $this->view($rally, 200);

        return $this->handleView($view);
    }

    public function getRalliesAction()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $rallies = $dm->getRepository('AppBundle:Rally')->findAll();

        $view = $this->view($rallies, 200);

        return $this->handleView($view);
    }

    public function postRalliesAction(Request $request)
    {
        $name = $request->get('name');
        $startDate = $request->get('startDate');
        $endDate = $request->get('endDate');

        if (empty($name) || empty($startDate) || empty($endDate)) {
            throw new HttpException(400, 'Missing required parameters');
        }

        $rally = new Rally($name, new \DateTime($startDate), new \DateTime($endDate));

        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($rally);
        $dm->flush();

        $view = $this->view($rally, 201);

        return $this->handleView($view);
    }

    public function getRalliesStagesAction($rallyId)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $rally = $dm->getRepository('AppBundle:Rally')->findOneById($rallyId);

        if (empty($rally)) {
            throw new HttpException(400, 'Cannot find rally');
        }

        $stages = $rally->getStages();

        $view = $this->view($stages);

        return $this->handleView($view);
    }

    public function postRalliesStagesAction(Request $request, $rallyId)
    {
        $number = $request->get('number');
        $name =  $request->get('name');
        $startTime = $request->get('startTime');
        $distance = $request->get('distance');

        $dm = $this->get('doctrine_mongodb')->getManager();
        $rally = $dm->getRepository('AppBundle:Rally')->findOneById($rallyId);

        if (empty($rally)) {
            throw new HttpException(400, 'Cannot find rally');
        }

        if (empty($number) || empty($name) || empty($startTime) || empty($distance)) {
            throw new HttpException(400, 'Missing required parameters');
        }

        $stage = new Stage($number, $name, new \DateTime($startTime), $distance);

        $rally->addStage($stage);

        $dm->persist($rally);
        $dm->flush();

        $view = $this->view($stage, 201);

        return $this->handleView($view);
    }
}
