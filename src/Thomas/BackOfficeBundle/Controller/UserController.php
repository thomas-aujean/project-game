<?php

namespace Thomas\BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Thomas\BackOfficeBundle\Entity\Coupon;
use Thomas\BackOfficeBundle\Form\CouponType;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function indexAction()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ThomasUserBundle:User')
        ;

        $listUsers = $repository->findBy(array('enabled' => 1));


        return $this->render('ThomasBackOfficeBundle:User:index.html.twig', array(
            'users' => $listUsers
        ));
    }

    public function viewAction(Request $request, $id)
    {

        $coupon = new Coupon();
        
        $form   = $this->get('form.factory')->create(CouponType::class, $coupon);

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('ThomasUserBundle:User')
        ;

        $orderep = $this->getDoctrine()
            ->getManager()
            ->getRepository('ThomasCoreBundle:MyOrder')
        ;

        $user = $repository->find($id);

        $orders = $orderep->findBy(array('statute' => [1,2], 'user' => $user));

        $nb = count($orders);
        $total = 0;
        foreach ($orders as $order){
            $total += $order->getAmount();
        }


        if (null === $user) {
            throw new NotFoundHttpException("Le user recheché n'existe pas.");
        }

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
      
            $data = $form->getData()->getPercent();
            
            
            if($data){
                $code = $data->getName();
                $percent = $data->getPercent();


                $message = (new \Swift_Message('Pour vous remercier de votre fidélité'))
                    ->setFrom(['thomas.aujean@gmail.com' => 'Project Games'])
                    ->setTo($user->getEmail())
                    ->setBody('
                        <h1>Vous trouvez les jeux retro trop chers ?</h1>
                        <p>Comme vous achetez souvent chez nous, nous souhaitons vous remercier avec un code promo</p>
                        <p>En entrant le code "' . $code . '" vous bénéficierez d\'une réduction de ' . $percent . ' % sur la totalité de votre commande.</p>
                        <p>A très bientôt sur <a href="shop.thomasaujean.com">Project Game</a>.</p>        
                    ' , 'text/html')
                ;
            $this->get('mailer')->send($message);


                $request->getSession()->getFlashBag()->add('notice', 'Code promo ' . $code . ' envoyé.');
                
                return $this->redirectToRoute('thomas_back_office_user_view', array('id' => $id));
            }

            }
      
            
          }


        // Le render ne change pas, on passait avant un tableau, maintenant un objet
        return $this->render('ThomasBackOfficeBundle:User:view.html.twig', array(
            'form' => $form->createView(),
            'user' => $user,
            'nb' => $nb,
            'total' => $total
        ));
    }
}
