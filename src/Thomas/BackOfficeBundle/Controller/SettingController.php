<?php

namespace Thomas\BackOfficeBundle\Controller;

use Thomas\CoreBundle\Entity\Setting;
use Thomas\CoreBundle\Form\SettingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class SettingController extends Controller
{
    public function indexAction()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ThomasCoreBundle:Setting')
        ;

        $listSettings = $repository->findAll();

        return $this->render('ThomasBackOfficeBundle:Setting:index.html.twig', array(
            'settings' => $listSettings
        ));
    }

  public function editAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $setting = $em->getRepository('ThomasCoreBundle:Setting')->find($id);

    if (null === $setting) {
      throw new NotFoundHttpException("Parametres introuvables.");
    }

    $form = $this->get('form.factory')->create(SettingType::class, $setting);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

      $em = $this->getDoctrine()->getManager();
      $em->persist($setting);
      $em->flush();
      $request->getSession()->getFlashBag()->add('notice', 'Parametres bien modifiés.');

      return $this->redirectToRoute('thomas_back_office_homepage' );
    }

    return $this->render('ThomasBackOfficeBundle:Setting:edit.html.twig', array(
      'form' => $form->createView(),'setting' => $setting
    ));
  }
}
