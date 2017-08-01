<?php

// src/OC/PlatformBundle/Controller/AdvertController.php

namespace Thomas\PlatformBundle\Controller;

use Thomas\PlatformBundle\Entity\Advert;
use Thomas\PlatformBundle\Entity\Image;
use Thomas\PlatformBundle\Entity\Application;
use Thomas\PlatformBundle\Entity\AdvertSkill;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Thomas\PlatformBundle\Form\AdvertType;
use Thomas\PlatformBundle\Form\AdvertEditType;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
//  ce use pour l'annotation security
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class AdvertController extends Controller
{


  public function indexAction($page)
  {
    if ($page < 1) {
      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
    }

    // Ici je fixe le nombre d'annonces par page à 3
    // Mais bien sûr il faudrait utiliser un paramètre, et y accéder via $this->container->getParameter('nb_per_page')
    $nbPerPage = 3;

    // On récupère notre objet Paginator
    $listAdverts = $this->getDoctrine()
      ->getManager()
      ->getRepository('ThomasPlatformBundle:Advert')
      ->getAdverts($page, $nbPerPage)
    ;

    // On calcule le nombre total de pages grâce au count($listAdverts) qui retourne le nombre total d'annonces
    $nbPages = ceil(count($listAdverts) / $nbPerPage);

    // Si la page n'existe pas, on retourne une 404
    if ($page > $nbPages) {
      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
    }

    // On donne toutes les informations nécessaires à la vue
    return $this->render('ThomasPlatformBundle:Advert:index.html.twig', array(
      'listAdverts' => $listAdverts,
      'nbPages'     => $nbPages,
      'page'        => $page,
    ));
  }





  public function viewAction($id)
  {
    $em = $this->getDoctrine()->getManager();

    // On récupère l'annonce $id
    $advert = $em->getRepository('ThomasPlatformBundle:Advert')->find($id);


    // $advert est donc une instance de Thomas\PlatformBundle\Entity\Advert
    // ou null si l'id $id  n'existe pas, d'où ce if :
    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    // On récupère la liste des candidatures de cette annonce
    $listApplications = $em
      ->getRepository('ThomasPlatformBundle:Application')
      ->findBy(array('advert' => $advert))
    ;

    // On récupère maintenant la liste des AdvertSkill
    $listAdvertSkills = $em
      ->getRepository('ThomasPlatformBundle:AdvertSkill')
      ->findBy(array('advert' => $advert))
    ;


    return $this->render('ThomasPlatformBundle:Advert:view.html.twig', array(
      'advert'           => $advert,
      'listApplications' => $listApplications,
      'listAdvertSkills' => $listAdvertSkills
    ));

  }




   /**
   * @Security("has_role('ROLE_USER')")
   */
  public function addAction(Request $request)
  {


    //  On vérifie que l'utilisateur dispose bien du rôle ROLE_USER
    // maintenant fait avec annotation
    // if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
    //   // Sinon on déclenche une exception « Accès interdit »
    //   throw new AccessDeniedException('Accès limité aux auteurs.');
    // }


    // On crée un objet Advert
    $advert = new Advert();

    // Ici, on préremplit avec la date d'aujourd'hui, par exemple
    // Cette date sera donc préaffichée dans le formulaire, cela facilite le travail de l'utilisateur
    // $advert->setDate(new \Datetime());

    // On crée le FormBuilder grâce au service form factory
    $form = $this->get('form.factory')->create(AdvertType::class, $advert);
    // ou
    // $form = $this->createForm(AdvertType::class, $advert)

    // On ajoute les champs de l'entité que l'on veut à notre formulaire
    // $formBuilder
    //   ->add('date',      DateType::class)
    //   ->add('title',     TextType::class)
    //   ->add('content',   TextareaType::class)
    //   ->add('author',    TextType::class)
    //   ->add('published', CheckboxType::class, array('required' => false))
    //   ->add('save',      SubmitType::class)
    // ;
    // Pour l'instant, pas de candidatures, catégories, etc., on les gérera plus tard

    // À partir du formBuilder, on génère le formulaire
    // $form = $formBuilder->getForm();

    // Si la requête est en POST
    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {


      // On fait le lien Requête <-> Formulaire
      // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
      // $form->handleRequest($request);

      // On vérifie que les valeurs entrées sont correctes
      // (Nous verrons la validation des objets en détail dans le prochain chapitre)
      // if ($form->isValid()) {
        // On enregistre notre objet $advert dans la base de données, par exemple
        $em = $this->getDoctrine()->getManager();
        $em->persist($advert);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

        // On redirige vers la page de visualisation de l'annonce nouvellement créée
        return $this->redirectToRoute('thomas_platform_view', array('id' => $advert->getId()));
      // }
    }

    // À ce stade, le formulaire n'est pas valide car :
    // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
    // - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau
    return $this->render('ThomasPlatformBundle:Advert:add.html.twig', array(
      'form' => $form->createView(),
    ));
  }





  public function editAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $advert = $em->getRepository('ThomasPlatformBundle:Advert')->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    // Ici encore, il faudra mettre la gestion du formulaire
    $form = $this->get('form.factory')->create(AdvertEditType::class, $advert);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

      $em = $this->getDoctrine()->getManager();
      $em->persist($advert);
      $em->flush();
      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

      return $this->redirectToRoute('thomas_platform_view', array('id' => $advert->getId()));
    }

    return $this->render('ThomasPlatformBundle:Advert:edit.html.twig', array(
      'form' => $form->createView(),'advert' => $advert
    ));
  }






  public function deleteAction(Request $request, $id)
  {
    $em = $this->getDoctrine()->getManager();

    $advert = $em->getRepository('ThomasPlatformBundle:Advert')->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'annonce contre cette faille
    $form = $this->get('form.factory')->create();

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em->remove($advert);
      $em->flush();

      $request->getSession()->getFlashBag()->add('info', "L'annonce a bien été supprimée.");

      return $this->redirectToRoute('thomas_platform_home');
    }
    
    return $this->render('ThomasPlatformBundle:Advert:delete.html.twig', array(
      'advert' => $advert,
      'form'   => $form->createView(),
    ));
  }

  public function menuAction($limit)
  {
    $em = $this->getDoctrine()->getManager();

    $listAdverts = $em->getRepository('ThomasPlatformBundle:Advert')->findBy(
      array(),                 // Pas de critère
      array('date' => 'desc'), // On trie par date décroissante
      $limit,                  // On sélectionne $limit annonces
      0                        // À partir du premier
    );

    return $this->render('ThomasPlatformBundle:Advert:menu.html.twig', array(
      'listAdverts' => $listAdverts
    ));
  }

  public function editImageAction($advertId)
  {
    $em = $this->getDoctrine()->getManager();

    // On récupère l'annonce
    $advert = $em->getRepository('ThomasPlatformBundle:Advert')->find($advertId);

    // On modifie l'URL de l'image par exemple
    $advert->getImage()->setUrl('test.png');

    // On n'a pas besoin de persister l'annonce ni l'image.
    // Rappelez-vous, ces entités sont automatiquement persistées car
    // on les a récupérées depuis Doctrine lui-même
    
    // On déclenche la modification
    $em->flush();

    return new Response('OK');
  }




}   