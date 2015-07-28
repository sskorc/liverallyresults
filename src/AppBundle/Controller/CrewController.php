<?php

namespace AppBundle\Controller;

use AppBundle\Document\Crew;
use AppBundle\Document\CrewMember;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CrewController extends FOSRestController
{
    public function getCrewsAction()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $crews = $dm->getRepository('AppBundle:Crew')->findAll();

        $view = $this->view($crews, 200);

        return $this->handleView($view);
    }

    public function postCrewsAction(Request $request)
    {
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
        $dm->flush();

        $view = $this->view($crew, 201);

        return $this->handleView($view);
    }
}
