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

        $em = $this->getDoctrine()->getManager();
        $em->persist($order);
        $em->flush();
        $session->remove('panier');
        $session->remove('coupon');
        
        $request->getSession()->getFlashBag()->add('notice', 'Votre commande a bien été enregistrée.');
        
//mail 


//$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
            //$transport = Swift_MailTransport::newInstance();
        $transport = Swift_SmtpTransport::newInstance('in-v3.mailjet.com', 25)
            ->setUsername('9f57d681db6bf5b4d4c0ba64e4f5ddb0')
            ->setPassword('04e65bc24a44dd51e5cd57918012d7d9')
            ; 
          $mailer = Swift_Mailer::newInstance($transport);
          $message = Swift_Message::newInstance('Message site project game')

          // Set the From address with an associative array
          ->setFrom(array('thomas.aujean@gmail.com' => 'Thomas'))

          // Set the To addresses with an associative array
          ->setTo(array('thomas.aujean@gmail.com' => 'Thomas'))

          // Give it a body
          ->setBody('Par prgizprehpih', 'text/html')
          ;

          $result = $mailer->send($message);


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
