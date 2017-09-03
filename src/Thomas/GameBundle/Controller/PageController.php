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

    public function profileAction()
    {

        return $this->render('ThomasGameBundle:Page:profile.html.twig', array());
    }

    public function myOrdersAction()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ThomasCoreBundle:MyOrder')
        ;

        $user = $this->getUser();

        $listOrders = $repository->findBy(
            array('user'=> $user->getId())
        );

        return $this->render('ThomasGameBundle:Page:myorders.html.twig', array(
            'orders' => $listOrders
        ));
    }

    public function myOrderAction($id)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ThomasCoreBundle:MyOrder')
        ;

        $order = $repository->find($id);

        $cart = unserialize($order->getDetail());

        return $this->render('ThomasGameBundle:Page:order.html.twig', array(
            'order' => $order,
            'cart' => $cart
        ));
    }
}
