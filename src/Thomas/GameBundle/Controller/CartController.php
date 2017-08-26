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
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        // if (!$session->has('panier')){
        //     $session->set('panier', []);
        // }
        $panier = $session->get('panier');
        dump($panier);die;
        return $this->render('ThomasGameBundle:Cart:index.html.twig');
    }

    public function addAction(Request $request, $id)
    {
        // $session = 

        $session = $request->getSession();

        if (!$session->has('panier')){
            dump($session);die;
            $session->set('panier', []);
        }
        $repository = $this->getDoctrine()
        ->getManager()
        ->getRepository('ThomasCoreBundle:Product')
        ;

        $product = $repository->find($id);
        $panier = $session->get('panier');

        $panier = $product;


        // if (array_key_exists($id, $panier)){
        

        // }

        // dump($request->attributes->get('id'));die;
        dump($panier);die;
        // dump($product->getId());die;

        return $this->redirect($this->generateUrl('thomas_game_cart'));

        // return $this->render('ThomasGameBundle:Cart:index.html.twig');
    }

    public function deleteAction($id)
    {


        return $this->render('ThomasGameBundle:Cart:delete.html.twig');
    }

}
