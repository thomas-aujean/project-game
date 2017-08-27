<?php

namespace Thomas\BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ThomasUserBundle:User')
        ;

        $listUsers = $repository->findAll();

        return $this->render('ThomasBackOfficeBundle:User:index.html.twig', array(
            'users' => $listUsers
        ));
    }
}
