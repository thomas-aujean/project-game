<?php

namespace Thomas\BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        return $this->render('ThomasBackOfficeBundle:User:index.html.twig', array(
            // ...
        ));
    }
}
