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
        if (!$session->has('panier')){
            $session->set('panier', []);
        }
        $panier = $session->get('panier');
        $total =0;
        foreach ($panier as $item){
            $total += $item['price'];
        }


        return $this->render('ThomasGameBundle:Cart:index.html.twig', array(
            'panier' => $panier,
            'total' => $total,
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
        


        if (!$session->has('panier')){
            $panier = $session->set('panier', []);
            
            $cartArray[0] = [
                'id'    => $product->getId(),
                'name'  => $product->getName(),
                'price' => $product->getPrice(),
                'unitPrice' => $product->getPrice(),
                'qty'   => 1,
            ];
            $session->set('panier', $cartArray);
        } else{

            $panier = $session->get('panier');

            foreach ($panier as $key => $item){
                if ($item['id'] == $product->getId()) {
                    $panier[$key]['price'] += $product->getPrice();
                    $panier[$key]['qty'] ++;
                    $added = true;
                } 

            }
            if ($added == false){
                $line = count($panier) - 1;
                $cartArray = [
                    'id'    => $product->getId(),
                    'name'  => $product->getName(),
                    'price' => $product->getPrice(),
                    'unitPrice' => $product->getPrice(),
                    'qty'   => 1,  
                ];

                array_push($panier, $cartArray);
            }
            
            $session->set('panier',$panier);
        
        }
   
        return $this->redirect($this->generateUrl('thomas_game_cart'));
    }

    public function deleteAction(Request $request, $id)
    {

        $session = $request->getSession();
        $panier = $session->get('panier');

        unset($panier[$id]);

        $session->set('panier', $panier);

        return $this->redirect($this->generateUrl('thomas_game_cart'));
    }

    public function removeCartAction(Request $request)
    {

        $user = $this->getUser();
        if ($user != null) {

            $message = (new \Swift_Message('Réduction exceptionnelle'))
                ->setFrom(['thomas.aujean@gmail.com' => 'Project Games'])
                ->setTo($user->getEmail())
                ->setBody('
                    <h1>Bonjour</h1>
                    <p>Vous aimez les jeux rétros. Et on trouve ça génial.</p>        
                    <p>Essayez donc le code promo "petitplus" pour votre prochaine commande.</p>
                    <p>A très bientôt sur <a href="shop.thomasaujean.com">Project Game</a>.</p>        
                ' , 'text/html')
            ;
            $this->get('mailer')->send($message);

        }

        $session = $request->getSession();
        $session->remove('panier');






        return $this->redirect($this->generateUrl('thomas_game_cart'));
    }

    public function addQtyAction(Request $request, $id)
    {

        $session = $request->getSession();
        $panier = $session->get('panier');

        $panier[$id]['qty']++;
        $panier[$id]['price'] = $panier[$id]['qty'] * $panier[$id]['unitPrice'];

        $session->set('panier', $panier);

        return $this->redirect($this->generateUrl('thomas_game_cart'));
    }

    public function removeQtyAction(Request $request, $id)
    {

        $session = $request->getSession();
        $panier = $session->get('panier');

        $panier[$id]['qty']--;
        $panier[$id]['price'] = $panier[$id]['qty'] * $panier[$id]['unitPrice'];

        if ($panier[$id]['qty'] == 0) {
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        return $this->redirect($this->generateUrl('thomas_game_cart'));
    }

}
