<?php

namespace Thomas\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Thomas\CoreBundle\Form\SystemSearchType;
use Thomas\CoreBundle\Form\GameSearchType;
use Thomas\CoreBundle\Form\SearchType;
use Thomas\CoreBundle\Entity\Product;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function gameIndexAction(Request $request, $page, $console = null, $name = null)
    {


        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
        $nbPerPage = 12;

        $listGames = $this->getDoctrine()
            ->getManager()
            ->getRepository('ThomasCoreBundle:Product')
            ->findGames($page, $nbPerPage, $console, $name)
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
                    ->findGames($page, $nbPerPage, $console, $name)
                ;

            }
        }
        $nbPages = ceil(count($listGames) / $nbPerPage);


        
        if (count($listGames) === 0) {
            $request->getSession()->getFlashBag()->add('notice', 'Aucun jeu ne correspond à votre demande.');
            return $this->redirectToRoute('thomas_game_games', array('page' => 1));
        }
        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }



        
        return $this->render('ThomasGameBundle:Product:gameindex.html.twig', array(
            'listGames' => $listGames,
            'form' => $form->createView(),
            'nbPages'     => $nbPages,
            'page'        => $page,
            'console'        => $console,
            'name'        => $name,
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
        if ($orders){

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
            arsort($dabest);
            $arrayKeys = array_keys($dabest);
            $product = $em->getRepository('ThomasCoreBundle:Product')->find($arrayKeys[0]);
            $product2 = $em->getRepository('ThomasCoreBundle:Product')->find($arrayKeys[1]);
            $product3 = $em->getRepository('ThomasCoreBundle:Product')->find($arrayKeys[2]);
        } else {

            $product =$product2 = $product3 ='';
        }
        
        return $this->render('ThomasGameBundle:Product:best.html.twig', array(
            'product' => $product,
            'product2' => $product2,
            'product3' => $product3,
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


    public function suggestionAction($filter, $id, $limit)
    {
        $em = $this->getDoctrine()->getManager();

        // $listProducts = $em->getRepository('ThomasCoreBundle:Product')->findBy(
        // array('system'=> $filter),                 // Pas de critère
        // array('id' => 'desc'), // On trie par date décroissante
        // $limit,                  // On sélectionne $limit annonces
        // 0                        // À partir du premier
        // );

        $listProducts = $em->getRepository('ThomasCoreBundle:Product')->findSuggestions($filter, $id, $limit);


        return $this->render('ThomasGameBundle:Product:suggestion.html.twig', array(
        'listProducts' => $listProducts
        ));
    }

    public function rateAction(Request $request, $id)
    {
        

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('ThomasCoreBundle:Product')
        ;

        $product = $repository->find($id);


        if ($request->isMethod('POST')) {
            // dump($request);die;
            $form->handleRequest($request);


            if( 1 == 0){
                return $this->redirectToRoute('thomas_game_view', array('id' =>$id));
            }

        }
        

        return $this->render('ThomasGameBundle:Product:rate.html.twig', array(
            'product' => $product
        ));
    }


}
