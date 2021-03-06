<?php

namespace Thomas\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Thomas\CoreBundle\Entity\MyOrder;
use Thomas\BackOfficeBundle\Entity\Coupon;
use Symfony\Component\HttpFoundation\Session\Session;
use Thomas\CoreBundle\Form\ValidCouponType;

class OrderController extends Controller
{
    public function recapAction(Request $request)
    {

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('ThomasBackOfficeBundle:Coupon')
        ;

        $session = $request->getSession();
        if (!$session->has('panier')){
            $session->set('panier', []);
        }
        if (!$session->has('coupon')){
            $session->set('coupon', []);
        } 

        $remise = $session->get('coupon');
        $panier = $session->get('panier');
        $subs = 0;

        $total =0;
        foreach ($panier as $item){
            $total += $item['price'];
        }

        if($remise){
            $subs = ($remise / 100 ) * $total;
        }


        $coupon = new Coupon();
        $form   = $this->get('form.factory')->create(ValidCouponType::class, $coupon);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                if ($data = $form->getData()){
                    $coupon = $repository->findOneByName($data->getName());
                    if ($coupon){
                        $session->set('coupon', $coupon->getPercent());
                        return $this->redirectToRoute('thomas_game_order');
                    }

                }
            }
        }


        return $this->render('ThomasGameBundle:Order:recap.html.twig', array(
            'panier' => $panier,
            'total' => $total,
            'subs' => $subs,
            'form' => $form->createView(),
        ));
    }

    public function validAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier')){
            $session->set('panier', []);
        }
        if (!$session->has('coupon')){
            $session->set('coupon', []);
        } 
        $remise = $session->get('coupon');
        $panier = $session->get('panier');
        $orderCart = serialize($panier);

        $subs = 0;
        $total = 0;
        
        foreach ($panier as $item){
            $total += $item['price'];
        }

        if($remise){
            $subs = ($remise / 100 ) * $total;
            $total = $total - $subs;
        } else {
            $remise = 0;
        }

        $order =  new MyOrder();
        $order->setUser($this->getUser());
        $order->setAmount($total);
        $order->setDetail($orderCart);
        $order->setCoupon($remise);

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('ThomasCoreBundle:Statute')
        ;

        $statute = $repository->find(1);

        $order->setStatute($statute);

        $em = $this->getDoctrine()->getManager();
        $em->persist($order);
        $em->flush();
        $session->remove('panier');
        $session->remove('coupon');
        
        $request->getSession()->getFlashBag()->add('notice', 'Votre commande a bien été enregistrée.');
        
//mail 

        $message = (new \Swift_Message('Votre commande est validée'))
            ->setFrom(['thomas.aujean@gmail.com' => 'Project Games'])
            ->setTo($this->getUser()->getEmail())
            ->setBody('
                <h1>Merci d\'avoir effectué votre commande chez nous</h1>
                <p>Vous pouvez télécharger votre facture et suivre votre commande dans votre espace client.</p>        
                <p>A très bientôt sur <a href="shop.thomasaujean.com">Project Game</a>.</p>        
            ' , 'text/html')
        ;
        $this->get('mailer')->send($message);

        return $this->redirectToRoute('thomas_core_home');
    }

}
