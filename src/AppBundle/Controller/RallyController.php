<?php

namespace AppBundle\Controller;

use AppBundle\Document\Rally;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RallyController extends FOSRestController
{
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
}
