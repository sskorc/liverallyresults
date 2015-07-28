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

        if (empty($name)) {
            throw new HttpException(400, 'Missing required parameters');
        }

        $product = new Rally();
        $product->setName($name);

        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($product);
        $dm->flush();

        $view = $this->view($product, 201);

        return $this->handleView($view);
    }
}
