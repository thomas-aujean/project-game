<?php

namespace Thomas\BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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


   /**
   * @Security("has_role('ROLE_USER')")
   */
  public function addAction(Request $request)
  {

    $product = new Product();

    
    return $this->render('ThomasPlatformBundle:Advert:add.html.twig', array(
      'form' => $form->createView(),
    ));
  }

}
