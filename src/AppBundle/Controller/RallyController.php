<?php

namespace AppBundle\Controller;

use AppBundle\Document\Crew;
use AppBundle\Document\CrewMember;
use AppBundle\Document\Rally;
use AppBundle\Document\Stage;
use AppBundle\Document\StageResult;
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

        $stage = new Stage((int) $number, $name, new \DateTime($startTime), $distance);

        $rally->addStage($stage);

        $dm->persist($rally);
        $dm->flush();

        $view = $this->view($stage, 201);

        return $this->handleView($view);
    }

    public function getRalliesCrewsAction(Request $request, $rallyId)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $rally = $dm->getRepository('AppBundle:Rally')->findOneById($rallyId);

        if (empty($rally)) {
            throw new HttpException(400, 'Cannot find rally');
        }

        $crews = $rally->getCrews();

        $view = $this->view($crews, 200);

        return $this->handleView($view);
    }


    public function postRalliesCrewsAction(Request $request, $rallyId)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $rally = $dm->getRepository('AppBundle:Rally')->findOneById($rallyId);

        if (empty($rally)) {
            throw new HttpException(400, 'Cannot find rally');
        }

        $number = $request->get('number');
        $car = $request->get('car');
        $group = $request->get('group');
        $driverFirstName = $request->get('driverFirstName');
        $driverLastName = $request->get('driverLastName');
        $driverNationality = $request->get('driverNationality');
        $coDriverFirstName = $request->get('coDriverFirstName');
        $coDriverLastName = $request->get('coDriverLastName');
        $coDriverNationality = $request->get('coDriverNationality');

        if (empty($driverFirstName) || empty($driverLastName) || empty($driverNationality)
            || empty($coDriverFirstName) || empty($coDriverLastName) || empty($coDriverNationality)
            || empty($number) || empty($car) || empty($group)
        ) {
            throw new HttpException(400, 'Missing required parameters');
        }

        $crew = new Crew(
            $number,
            new CrewMember($driverFirstName, $driverLastName, $driverNationality),
            new CrewMember($coDriverFirstName, $coDriverLastName, $coDriverNationality),
            $car,
            $group
        );


        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($crew);

        $rally->addCrew($crew);
        $dm->persist($rally);

        $dm->flush();

        $view = $this->view($crew, 201);

        return $this->handleView($view);
    }

    public function getRalliesStagesResultsAction($rallyId, $stageNumber)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();

        $rally = $dm->getRepository('AppBundle:Rally')->findOneById($rallyId);
        if (empty($rally)) {
            throw new HttpException(400, 'Cannot find rally');
        }

        $stage = $rally->getStageByNumber($stageNumber);
        if (empty($stage)) {
            throw new HttpException(400, 'Cannot find stage');
        }

        $results = $stage->getResults();

        $view = $this->view($results, 200);

        return $this->handleView($view);
    }

    public function postRalliesStagesResultsAction(Request $request, $rallyId, $stageNumber)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();

        $rally = $dm->getRepository('AppBundle:Rally')->findOneById($rallyId);
        if (empty($rally)) {
            throw new HttpException(400, 'Cannot find rally');
        }

        $stage = $rally->getStageByNumber($stageNumber);
        if (empty($stage)) {
            throw new HttpException(400, 'Cannot find stage');
        }

        $crewNumber = $request->get('crewNumber');
        $time = $request->get('time');
        $penalty = $request->get('penalty');

        if (empty($crewNumber) || empty($time)) {
            throw new HttpException(400, 'Missing required parameters');
        }

        if (empty($penalty)) {
            $penalty = 0;
        }

        $dm->refresh($rally);

        $crew = $rally->getCrewByNumber($crewNumber);
        if (empty($crew)) {
            throw new HttpException(400, 'Cannot find crew');
        }

        $result = new StageResult($crew, (int) $time, (int) $penalty);
        $stage->addResult($result);

        $rally->updateStage($stage);

        $dm->persist($rally);
        $dm->flush();

        $view = $this->view($result, 201);

        return $this->handleView($view);
    }
}
