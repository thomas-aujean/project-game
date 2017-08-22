<?php

namespace Thomas\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    public function indexAction()
    {
        return $this->render('ThomasGameBundle:Product:index.html.twig');
    }


    public function viewAction($id, Request $request)
    {
        return $this->render('ThomasGameBundle:Product:view.html.twig');
    }
}
