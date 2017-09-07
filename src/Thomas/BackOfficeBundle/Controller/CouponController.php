<?php

namespace Thomas\BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Thomas\CoreBundle\Form\CouponType;
use Thomas\BackOfficeBundle\Entity\Coupon;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CouponController extends Controller
{
    public function indexAction()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ThomasBackOfficeBundle:Coupon')
        ;

        $listCoupons = $repository->findAll();

        return $this->render('ThomasBackOfficeBundle:Coupon:index.html.twig', array(
            'coupons' => $listCoupons
        ));
    }

    public function viewAction($id)
    {
        $repository = $this->getDoctrine()
        ->getManager()
        ->getRepository('ThomasBackOfficeBundle:Coupon')
        ;

        $coupon = $repository->find($id);

        if (null === $coupon) {
        throw new NotFoundHttpException("La remise rechechée n'existe pas.");
        }

        // Le render ne change pas, on passait avant un tableau, maintenant un objet
        return $this->render('ThomasBackOfficeBundle:Coupon:view.html.twig', array(
        'coupon' => $coupon
        ));
    }



    public function addAction(Request $request)
    {
        $coupon = new Coupon();

        $form   = $this->get('form.factory')->create(CouponType::class, $coupon);
        
        if ($request->isMethod('POST')) {
        $form->handleRequest($request);
        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($coupon);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Remise bien enregistrée.');

            return $this->redirectToRoute('thomas_back_office_coupon_view', array('id' => $coupon->getId()));
        }
        }


        return $this->render('ThomasBackOfficeBundle:Coupon:add.html.twig', array(
        'form' => $form->createView(),
        ));
    }

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $coupon = $em->getRepository('ThomasBackOfficeBundle:Coupon')->find($id);

        if (null === $coupon) {
        throw new NotFoundHttpException("La remise rechechée n'existe pas.");
        }

        $form = $this->get('form.factory')->create(CouponType::class, $coupon);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

        $em = $this->getDoctrine()->getManager();
        $em->persist($coupon);
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', 'Remise bien modifiée.');

        return $this->redirectToRoute('thomas_back_office_coupon_view', array('id' => $coupon->getId()));
        }

        return $this->render('ThomasBackOfficeBundle:Coupon:edit.html.twig', array(
        'form' => $form->createView(),
        'coupon' => $coupon
        ));
    }


    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $coupon = $em->getRepository('ThomasBackOfficeBundle:Coupon')->find($id);

        if (null === $coupon) {
        throw new NotFoundHttpException("La remise n'existe pas.");
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        $em->remove($coupon);
        $em->flush();

        $request->getSession()->getFlashBag()->add('info', "La remise a bien été supprimée.");

        return $this->redirectToRoute('thomas_back_office_coupon_index');
        }
        
        return $this->render('ThomasBackOfficeBundle:Coupon:delete.html.twig', array(
        'coupon' => $coupon,
        'form'   => $form->createView(),
        ));
    }

}
