<?php

namespace Thomas\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ThomasPlatformBundle:Default:index.html.twig');
    }
}
