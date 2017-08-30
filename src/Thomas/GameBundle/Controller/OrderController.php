<?php

namespace Thomas\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Thomas\CoreBundle\Entity\MyOrder;
use Symfony\Component\HttpFoundation\Session\Session;

class OrderController extends Controller
{
    public function recapAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier')){
            $session->set('panier', []);
            // redirect to accueil et dire que le panier est vide flashbag      TO DO §§
        }

        $panier = $session->get('panier');
        $total =0;
        foreach ($panier as $item){
            $total += $item['price'];
        }


        return $this->render('ThomasGameBundle:Order:recap.html.twig', array(
            'panier' => $panier,
            'total' => $total,
        ));
    }

    public function validAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier')){
            $session->set('panier', []);
            // redirect to accueil et dire que le panier est vide flashbag      TO DO §§
        }

        $panier = $session->get('panier');
        $orderCart = serialize($panier);

        $total =0;
        foreach ($panier as $item){
            $total += $item['price'];
        }

        $order =  new MyOrder();
        $order->setUser($this->getUser());
        $order->setAmount($total);
        $order->setDetail($orderCart);

        $em = $this->getDoctrine()->getManager();
        $em->persist($order);
        $em->flush();
        $session->remove('panier');
        
        $request->getSession()->getFlashBag()->add('notice', 'Votre commande a bien été enregistrée.');
        
        return $this->redirectToRoute('thomas_core_home');
    }

    /**
     * Export to PDF
     * 
     * @Route("/pdf", name="acme_demo_pdf")
     */
    public function pdfAction()
    {
        $html = $this->renderView('ThomasGameBundle:Order:pdf.html.twig');

        $filename = sprintf('test-%s.pdf', date('Y-m-d'));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
            ]
        );
    } 
}
