<?php

namespace Thomas\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

    public function disableAction(Request $request)
    {
        $user = $this->getUser();

        if (!$user){
            $request->getSession()->getFlashBag()->add('notice', 'Vous devez être connecté pour y accéder.');
            return $this->redirectToRoute('thomas_core_home');
        }

        $user->setEnabled(0);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
      

        // $request->getSession()->getFlashBag()->add('notice', 'Votre compte a bien été effacé.');
        return $this->redirectToRoute('fos_user_security_logout');
    }

    public function myOrdersAction(Request $request)
    {
        $user = $this->getUser();

        if (!$user){
            $request->getSession()->getFlashBag()->add('notice', 'Vous devez être connecté pour y accéder.');
            return $this->redirectToRoute('thomas_core_home');
        }

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ThomasCoreBundle:MyOrder')
        ;


        $listOrders = $repository->findBy(
            array('user'=> $user->getId()),
            ['created' => 'DESC']
        );

        return $this->render('ThomasGameBundle:Page:myorders.html.twig', array(
            'orders' => $listOrders
        ));
    }

    public function myOrderAction(Request $request, $id)
    {
        $user = $this->getUser();

        if (!$user){
            $request->getSession()->getFlashBag()->add('notice', 'Vous devez être connecté pour y accéder.');
            return $this->redirectToRoute('thomas_core_home');
        }

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ThomasCoreBundle:MyOrder')
        ;

        $order = $repository->find($id);

        if ($user->getId() != $order->getUser()->getId()){
            $request->getSession()->getFlashBag()->add('notice', 'Vous ne pouvez pas accéder à cette commande.');
            return $this->redirectToRoute('thomas_core_home');
        }

        $cart = unserialize($order->getDetail());

        return $this->render('ThomasGameBundle:Page:order.html.twig', array(
            'order' => $order,
            'cart' => $cart
        ));
    }

    public function pdfAction(Request $request, $id)
    {

        $user = $this->getUser();
        
        if (!$user){
            $request->getSession()->getFlashBag()->add('notice', 'Vous devez être connecté pour y accéder.');
            return $this->redirectToRoute('thomas_core_home');
        }

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ThomasCoreBundle:MyOrder')
        ;
        $order = $repository->find($id);

        if ($user->getId() != $order->getUser()->getId()){
            $request->getSession()->getFlashBag()->add('notice', 'Vous ne pouvez pas accéder à cette commande.');
            return $this->redirectToRoute('thomas_core_home');
        }



        $cart = unserialize($order->getDetail());

        $tva = $order->getAmount()*0.833;
        $tva = round($tva,2);

        $html = $this->renderView(
             'ThomasGameBundle:Page:pdf.html.twig',
             array(
              'order' => $order,
              'cart' => $cart,
              'tva' => $tva
             )
        );
      
        $this->returnPDFResponseFromHTML($html);
    }


    public function returnPDFResponseFromHTML($html){

        $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetAuthor('Project Game');
        $pdf->SetTitle(('Votre commande'));
        $pdf->SetSubject('Votre commande');
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('helvetica', '', 11, '', true);
        $pdf->AddPage();
        
        $filename = 'commande_project_game';
        
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        $pdf->Output($filename.".pdf",'I'); // This will output the PDF as a response directly
    }

}
