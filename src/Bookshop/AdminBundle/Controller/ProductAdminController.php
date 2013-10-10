<?php

namespace Bookshop\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Description of UserAdminController
 *
 * @author mzaharie
 */
class ProductAdminController extends Controller {

    public function indexAction() {
        
        $filter = "";
        if (isset($_GET['title'])) {
            $filter.= " AND p.title like '%" . $_GET['title'] . "%'";
        }
        if (isset($_GET['category']) && strlen($_GET['category'])) {
            $filter.= " AND c.id = " . $_GET['category'];
        }
        if (isset($_GET['stock']))
            switch ($_GET['stock']) {
                case 'on':
                    $filter .= ' and p.stock>0';
                    break;
            }
        else{
            if (isset($_GET['title']) || isset($_GET['category'])) {
                $filter .= ' and p.stock>=0';
            }
        }


        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('BookshopBookshopBundle:Category')->findAll();
        $count = $em
                ->createQuery('SELECT COUNT(p) FROM BookshopBookshopBundle:Product p INNER JOIN BookshopBookshopBundle:Category c WITH c = p.category WHERE p.active=1'.$filter)
                ->getSingleScalarResult();
        $dql = "SELECT p FROM BookshopBookshopBundle:Product p INNER JOIN BookshopBookshopBundle:Category c WITH c = p.category WHERE p.active=1";
        $dql.=$filter;

        $query = $em->createQuery($dql)->setHint('knp_paginator.count', $count);
        

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, $this->get('request')->query->get('page', 1)/* page number */, 10/* limit per page */, array('distinct' => false)
        );
        return $this->render('BookshopAdminBundle:ProductAdmin:index.html.twig', array('products' => $pagination, 'categories' => $categories));
    }

}