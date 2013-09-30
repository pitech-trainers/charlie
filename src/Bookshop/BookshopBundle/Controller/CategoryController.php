<?php

namespace Bookshop\BookshopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryController extends Controller {

    public function categoryAction($id) {
        $em = $this->getDoctrine()->getManager();
        $prods = $em->getRepository('BookshopBookshopBundle:Product')->getProducts($id);
        if (!$prods) {
            throw $this->createNotFoundException('Unable to find products in this Category.');
        }

        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT a FROM BookshopBookshopBundle:Product a WHERE a.active=1 and a.category=".$id;
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, $this->get('request')->query->get('page', 1)/* page number */, 9/* limit per page */
        );


        return $this->render('BookshopBookshopBundle:Default:category.html.twig', array(
                    'products' => $pagination
        ));
    }

}
