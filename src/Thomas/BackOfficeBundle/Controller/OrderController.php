<?php

namespace Thomas\BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OrderController extends Controller
{
    public function indexAction()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ThomasCoreBundle:MyOrder')
        ;

        // $listOrders = $repository->findAll();
        $listOrders = $repository->findBy(array(), array('created' => 'DESC'));

        return $this->render('ThomasBackOfficeBundle:Order:index.html.twig', array(
            'orders' => $listOrders
        ));
    }

    public function viewAction($id)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ThomasCoreBundle:MyOrder')
        ;

        $order = $repository->find($id);

        $cart = unserialize($order->getDetail());

        return $this->render('ThomasBackOfficeBundle:Order:view.html.twig', array(
            'order' => $order,
            'cart' => $cart
        ));
    }

}
