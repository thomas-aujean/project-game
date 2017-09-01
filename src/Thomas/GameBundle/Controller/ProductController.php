<?php

namespace Thomas\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Thomas\CoreBundle\Form\SystemSearchType;
use Thomas\CoreBundle\Form\GameSearchType;
use Thomas\CoreBundle\Form\SearchType;
use Thomas\CoreBundle\Entity\Product;

class ProductController extends Controller
{
    public function indexAction()
    {

        $product = new Product();
        $form   = $this->get('form.factory')->create(ProductSearchType::class, $product);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $test =$data->getBrand();
                
                dump($data->getBrand()->getId());
                dump($data);
                dump($request);
                // dump($form);
                // dump($request->request->get('brand'));
                die;
                // $test =$request->request->all();
                $listSystems = $this->getDoctrine()->getManager()
                    ->getRepository('ThomasCoreBundle:Product')
                    ->findSystems($data)
                ;

            }
        }
        return $this->render('ThomasGameBundle:Product:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    public function systemIndexAction(Request $request)
    {
        $listSystems = $this->getDoctrine()
            ->getManager()
            ->getRepository('ThomasCoreBundle:Product')
            ->findSystems()
        ;

        $product = new Product();
        $form   = $this->get('form.factory')->create(SystemSearchType::class, $product);


        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $test =$data->getBrand();
                if (!$test) {
                    $id = null;
                } else {
                    $id = $data->getBrand()->getId();
                }
                
                $listSystems = $this->getDoctrine()->getManager()
                    ->getRepository('ThomasCoreBundle:Product')
                    ->findSystems($id)
                ;

            }
        }


        return $this->render('ThomasGameBundle:Product:systemIndex.html.twig', array(
            'form' => $form->createView(),
            'listSystems' => $listSystems,
            // 'test' => $test,
        ));
    }

    public function gameIndexAction(Request $request)
    {
        $listGames = $this->getDoctrine()
            ->getManager()
            ->getRepository('ThomasCoreBundle:Product')
            ->findGames()
        ;

        $product = new Product();
        $form   = $this->get('form.factory')->create(GameSearchType::class, $product);


        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $system =$data->getSystem();
                if (!$system) {
                    $console = null;
                } else {
                    $console = $data->getSystem()->getId();
                }
                $name =$data->getName();
                
                $listGames = $this->getDoctrine()->getManager()
                    ->getRepository('ThomasCoreBundle:Product')
                    ->findGames($console, $name)
                ;

            }
        }


        return $this->render('ThomasGameBundle:Product:gameIndex.html.twig', array(
            'listGames' => $listGames,
            'form' => $form->createView(),
        ));
    }

    public function accessIndexAction()
    {

        $listAccess = $this->getDoctrine()
            ->getManager()
            ->getRepository('ThomasCoreBundle:Product')
            ->findAccess()
        ;

        return $this->render('ThomasGameBundle:Product:accessIndex.html.twig', array(
            'listAccess' => $listAccess,
        ));
    }


    public function viewAction($id, Request $request)
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
        return $this->render('ThomasGameBundle:Product:view.html.twig', array(
        'product' => $product
        ));
    }

    public function menuAction($limit)
    {
        $em = $this->getDoctrine()->getManager();

        $listProducts = $em->getRepository('ThomasCoreBundle:Product')->findBy(
        array(),                 // Pas de critère
        array('id' => 'desc'), // On trie par date décroissante
        $limit,                  // On sélectionne $limit annonces
        0                        // À partir du premier
        );

        return $this->render('ThomasGameBundle:Product:menu.html.twig', array(
        'listProducts' => $listProducts
        ));
    }

    public function bestAction($limit)
    {
        
        $em = $this->getDoctrine()->getManager();

        $orders = $em->getRepository('ThomasCoreBundle:MyOrder')->findAll();
        foreach ($orders as $order) {
            $details = unserialize($order->getDetail());
            foreach ($details as  $key => $detail){
                $bests[] = [
                    'id' => $detail['id'],
                    'qty' => $detail['qty'],
                ];
            }
        }
        
        foreach($bests as $best){
            if (empty($dabest)){
                $dabest = [
                    $best['id'] => $best['qty']
                ];

            } else {
                if(isset($dabest[$best['id']])){
                    $dabest[$best['id']] = intval($dabest[$best['id']]) + intval($best['qty']);
                } else{
                    $dabest[$best['id']] = $best['qty'];
                }
            }           
        }
         dump($dabest);die;
        $listProducts = [];
        return $this->render('ThomasGameBundle:Product:best.html.twig', array(
            'bests' => $dabest
        ));
    }

    public function settingAction()
    {
        $em = $this->getDoctrine()->getManager();

        $setting = $em->getRepository('ThomasCoreBundle:Setting')->find(1);

        return $this->render('ThomasGameBundle:Product:setting.html.twig', array(
        'setting' => $setting
        ));
    }

    public function searchAction(Request $request, $string = null)
    {
        $product = new Product();
        $form   = $this->get('form.factory')->create(SearchType::class, $product);
        // $form   = $this->get('form.factory')->create(SearchType::class);

        if ($request->isMethod('POST')) {
// dump($request);die;
            $form->handleRequest($request);
            if ($form->isValid()) {
                return $this->render('ThomasGameBundle:Product:systemIndex.html.twig', array(
                    'form' => $form->createView(),
                    'listSystems' => $listSystems,
                    // 'test' => $test,
                 ));

            }
        }


        return $this->render('ThomasGameBundle:Product:search.html.twig', array(
            'form' => $form->createView()
        ));
    }


    public function suggestionAction($filter, $limit)
    {
        $em = $this->getDoctrine()->getManager();

        $listProducts = $em->getRepository('ThomasCoreBundle:Product')->findBy(
        array('system'=> $filter),                 // Pas de critère
        array('id' => 'desc'), // On trie par date décroissante
        $limit,                  // On sélectionne $limit annonces
        0                        // À partir du premier
        );

        return $this->render('ThomasGameBundle:Product:suggestion.html.twig', array(
        'listProducts' => $listProducts
        ));
    }

    public function rateAction(Request $request, $id)
    {
        

        return $this->redirectToRoute('thomas_game_view', array('id' =>$id));
    }


}
