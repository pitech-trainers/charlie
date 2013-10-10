<?php

namespace Bookshop\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Description of UserAdminController
 *
 * @author mzaharie
 */
class ProductAdminController extends Controller 
{
    public function indexAction() 
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('BookshopBookshopBundle:Category')->findAll();
        $count = $em
                ->createQuery('SELECT COUNT(p) FROM BookshopBookshopBundle:Product p WHERE p.active=1')
                ->getSingleScalarResult();
        $dql = "SELECT p FROM BookshopBookshopBundle:Product p INNER JOIN BookshopBookshopBundle:Category c WITH c = p.category WHERE p.active=1";
        $query = $em->createQuery($dql)->setHint('knp_paginator.count', $count);;

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, 
                $this->get('request')->query->get('page', 1)/* page number */, 
                10/* limit per page */,
                array('distinct' => false)
        );
        return $this->render('BookshopAdminBundle:ProductAdmin:index.html.twig', array('products' => $pagination, 'categories' => $categories));
    }
    
}