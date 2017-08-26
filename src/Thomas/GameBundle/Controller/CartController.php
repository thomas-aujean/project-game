<?php

namespace Thomas\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Thomas\CoreBundle\Form\ProductSearchType;
use Thomas\CoreBundle\Form\SearchType;
use Thomas\CoreBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Session\Session;

class CartController extends Controller
{
    public function indexAction()
    {

        
        return $this->render('ThomasGameBundle:Cart:index.html.twig');
    }

    public function addAction(Request $request, $id)
    {
        $session = new Session();
        if (!$session->has('panier')){
            $session->set('panier', []);
        }
// dump($session);die;
        return $this->redirect($this->generateUrl('thomas_game_cart'));

        // return $this->render('ThomasGameBundle:Cart:index.html.twig');
    }

    public function deleteAction($id)
    {


        return $this->render('ThomasGameBundle:Cart:delete.html.twig');
    }

}
