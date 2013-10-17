<?php

namespace Bookshop\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Bookshop\BookshopBundle\Entity\User;
use Bookshop\BookshopBundle\Entity\Address;
use Bookshop\BookshopBundle\Entity\State;
use Bookshop\BookshopBundle\Entity\BookshopOrder;
/**
 * Description of OrderAdminController
 *
 * @author mzaharie
 */
class OrderAdminController extends Controller{
    
    public function indexAction() {
        $filter = $this->createSqlFilter();
        
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
        
        $states = $em->getRepository("BookshopBookshopBundle:State")->findAll();
        
        return $this->render('BookshopAdminBundle:OrderAdmin:index.html.twig', array('orders' => $pagination, 'states' => $states));
    }
    
    public function setStateAction($id,$stateId){
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository("BookshopBookshopBundle:BookshopOrder")->find($id);
        $state = $em->getRepository("BookshopBookshopBundle:State")->find($stateId);
        $order->setState($state);
        if($state->getId() == 4){
            //$em->getRepository("BookshopBookshopBundle:BookshopOrder")->cancelCart(); // pun produsele din nou pe stoc dar las cartul(si cart_items) inactiv. Astfel raman informatiile despre comanda
            //to do
        }
        
        $em->persist($order);
        $em->flush($order);
        
        $url = $this->getRequest()->headers->get("referer");
        return new RedirectResponse($url);
    }
    
    private function createSqlFilter(){
        $filter = "";
        if (isset($_GET['username'])) {
            $filter.= " AND u.username like '%" . $_GET['username'] . "%'";
        }
        if (isset($_GET['state']) && strlen($_GET['state'])>0) {
            $filter.= " AND s.id = " . $_GET['state'];
        }

        if (isset($_GET['created'])){
            $now = new \DateTime();
            $nowStr = $now->format("Y-m-d");
            $oneYearAgoStr = date("Y-m-d", strtotime(date("Y-m-d", strtotime($nowStr)) . " - 1 year"));
            
            switch ($_GET['created']) {
                case 'all':
                    break;
                case 'day':
                    $filter .= " AND o.date > DATE_SUB('$nowStr', 1, 'day')";
                    break;
                case 'month':
                    $filter .= " AND o.date > DATE_SUB('$nowStr', 1, 'month')";
                    break;
                case 'year':
                    $filter .= " AND o.date > '$oneYearAgoStr'"; //DATE_SUB don'twork for years
                    break;
            }
        }
        return $filter;
    }
}

?>
