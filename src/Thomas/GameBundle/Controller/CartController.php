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
        
        
// dump($this->getUser());die;
// dump($panier);die;


        return $this->render('ThomasGameBundle:Cart:index.html.twig', array(
            'panier' => $panier,
        ));
    }

    public function addAction(Request $request, $id)
    {
        $added = false;

        $repository = $this->getDoctrine()
        ->getManager()
        ->getRepository('ThomasCoreBundle:Product')
        ;

        $product = $repository->find($id);

        $session = $request->getSession();
        // $session->remove('panier');die;


        if (!$session->has('panier')){
            $panier = $session->set('panier', []);
            
            $cartArray[1] = [
                'id'    => $product->getId(),
                'name'  => $product->getName(),
                'price' => $product->getPrice(),
                'qty'   => 1,
                'line'   => 1,
            ];
            $session->set('panier',$cartArray);
        } else{

            $panier = $session->get('panier');

            foreach ($panier as $item){
                if ($item['id'] == $product->getId()) {
                    $panier[$item['line']]['price'] += $product->getPrice();
                    $panier[$item['line']]['qty'] ++;
                    $added = true;
                } 

            }
            if ($added == false){
                $line = count($panier);
                $cartArray = [
                    'id'    => $product->getId(),
                    'name'  => $product->getName(),
                    'price' => $product->getPrice(),
                    'qty'   => 1,  
                    'line'  => $line +1,
                ];

                array_push($panier, $cartArray);
            }
            
           

            
            $session->set('panier',$panier);
        
        }



        

        // dump($session->get('panier'));die;

        
        return $this->redirect($this->generateUrl('thomas_game_cart'));
    }

    public function deleteAction($id)
    {


        return $this->render('ThomasGameBundle:Cart:delete.html.twig');
    }

}
