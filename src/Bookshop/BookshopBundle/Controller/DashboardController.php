<?php

namespace Bookshop\BookshopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bookshop\BookshopBundle\Entity\User;

class DashboardController extends Controller
{
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        
        return $this->render('BookshopBookshopBundle:Dashboard:index.html.twig');
    }
    
    public function billingAddressShowAction()
    {   
        $user = new User();
        $user = $this->get('security.context')->getToken()->getUser();
        $billingAddress = $user->getBillingAddress();
        
        //$em = $this->getDoctrine()->getManager();
        //$entity = $em->getRepository('BookshopBundle:Address')->find($id);
        
        return $this->render('BookshopBookshopBundle:Dashboard:billingAddressShow.html.twig', array('billing_address' => $billingAddress));
    }
}
