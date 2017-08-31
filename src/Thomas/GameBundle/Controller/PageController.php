<?php

namespace Thomas\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function qsnAction()
    {

        return $this->render('ThomasGameBundle:Page:qsn.html.twig', array());
    }
    public function mlAction()
    {

        return $this->render('ThomasGameBundle:Page:ml.html.twig', array());
    }
    public function cgvAction()
    {

        return $this->render('ThomasGameBundle:Page:cgv.html.twig', array());
    }
}
