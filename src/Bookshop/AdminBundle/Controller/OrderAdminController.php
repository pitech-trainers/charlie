<?php

namespace Bookshop\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Bookshop\BookshopBundle\Entity\User;
use Bookshop\BookshopBundle\Entity\Address;
use Bookshop\BookshopBundle\Entity\State;
/**
 * Description of OrderAdminController
 *
 * @author mzaharie
 */
class OrderAdminController extends Controller{
    
    public function indexAction() {
        $filter = ""; //to do
        
        $em = $this->getDoctrine()->getManager();
        $count = $em
                ->createQuery('SELECT COUNT(o) FROM BookshopBookshopBundle:BookshopOrder o 
                    INNER JOIN BookshopBookshopBundle:User u WITH u = o.user 
                    INNER JOIN BookshopBookshopBundle:State s WITH s = o.state 
                    WHERE 1=1' . $filter)
                ->getSingleScalarResult();
        
        $dql = "SELECT o FROM BookshopBookshopBundle:BookshopOrder o 
                    INNER JOIN BookshopBookshopBundle:User u WITH u = o.user 
                    INNER JOIN BookshopBookshopBundle:State s WITH s = o.state 
                    WHERE 1=1";
        $dql.=$filter;

        $query = $em->createQuery($dql)->setHint('knp_paginator.count', $count);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, $this->get('request')->query->get('page', 1)/* page number */, 
                2/* limit per page */, 
                array('distinct' => false)
                );
        return $this->render('BookshopAdminBundle:OrderAdmin:index.html.twig', array('orders' => $pagination));
    }
}

?>
