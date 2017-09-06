<?php

namespace Thomas\BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends Controller
{
    public function indexAction(Request $request)
    {

        // if ($page < 1) {
        //     throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        // }
        // $nbPerPage = 10;

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ThomasCoreBundle:MyOrder')
        ;


        // $listOrders = $repository->findOrders($page, $nbPerPage);
        // $nbPages = ceil(count($listOrders) / $nbPerPage);



        // $listOrders = $repository->findAll();
        $listOrders = $repository->findBy(array('statute' => [1,2]), array('created' => 'DESC'));

        return $this->render('ThomasBackOfficeBundle:Order:index.html.twig', array(
            'orders' => $listOrders,
            // 'nbPages'     => $nbPages,
            // 'page'        => $page,
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


    public function pdfAction($id){
        // You can send the html as you want
       //$html = '<h1>Plain HTML</h1>';
    
        // but in this case we will render a symfony view !
        // We are in a controller and we can use renderView function which retrieves the html from a view
        // then we send that html to the user.
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ThomasCoreBundle:MyOrder')
        ;
        $order = $repository->find($id);
        $cart = unserialize($order->getDetail());

        $tva = $order->getAmount()*0.833;
        $tva = round($tva,2);
        
        $html = $this->renderView(
             'ThomasBackOfficeBundle:Order:pdf.html.twig',
             array(
              'order' => $order,
              'cart' => $cart,
              'tva'=> $tva
             )
        );
      
        $this->returnPDFResponseFromHTML($html);
    }


    public function returnPDFResponseFromHTML($html){
        //set_time_limit(30); uncomment this line according to your needs
        // If you are not in a controller, retrieve of some way the service container and then retrieve it
        //$pdf = $this->container->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        //if you are in a controlller use :
        $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetAuthor('Our Code World');
        $pdf->SetTitle(('Our Code World Title'));
        $pdf->SetSubject('Our Code World Subject');
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('helvetica', '', 11, '', true);
        //$pdf->SetMargins(20,20,40, true);
        $pdf->AddPage();
        
        $filename = 'ourcodeworld_pdf_demo';
        
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        $pdf->Output($filename.".pdf",'I'); // This will output the PDF as a response directly
    }
}
