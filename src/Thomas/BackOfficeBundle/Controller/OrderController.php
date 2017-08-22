<?php

namespace Thomas\BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OrderController extends Controller
{
    public function indexAction()
    {
        return $this->render('ThomasBackOfficeBundle:Order:index.html.twig', array(
            // ...
        ));
    }

}
