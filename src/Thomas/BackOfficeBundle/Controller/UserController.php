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

    public function viewAction($id)
    {
        $repository = $this->getDoctrine()
        ->getManager()
        ->getRepository('ThomasUserBundle:User')
        ;

        $user = $repository->find($id);

        if (null === $user) {
        throw new NotFoundHttpException("Le user recheché n'existe pas.");
        }

        // Le render ne change pas, on passait avant un tableau, maintenant un objet
        return $this->render('ThomasBackOfficeBundle:User:view.html.twig', array(
        'user' => $user
        ));
    }
}
