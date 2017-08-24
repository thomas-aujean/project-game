<?php

namespace Thomas\BackOfficeBundle\Controller;

use Thomas\CoreBundle\Entity\Product;
use Thomas\CoreBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ProductController extends Controller
{
    public function indexAction()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ThomasCoreBundle:Product')
        ;

        $listProducts = $repository->findAll();

        return $this->render('ThomasBackOfficeBundle:Product:index.html.twig', array(
            'products' => $listProducts
        ));
    }

    public function viewAction($id)
    {
        $repository = $this->getDoctrine()
        ->getManager()
        ->getRepository('ThomasCoreBundle:Product')
        ;

        $product = $repository->find($id);

        if (null === $product) {
        throw new NotFoundHttpException("Le produit recheché n'existe pas.");
        }

        // Le render ne change pas, on passait avant un tableau, maintenant un objet
        return $this->render('ThomasBackOfficeBundle:Product:view.html.twig', array(
        'product' => $product
        ));
    }



  public function addAction(Request $request)
  {
    $product = new Product();

    $form   = $this->get('form.factory')->create(ProductType::class, $product);
    
    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Produit bien enregistré.');

        return $this->redirectToRoute('thomas_back_office_product_view', array('id' => $product->getId()));
      }
    }


    return $this->render('ThomasBackOfficeBundle:Product:add.html.twig', array(
      'form' => $form->createView(),
    ));
  }

}
