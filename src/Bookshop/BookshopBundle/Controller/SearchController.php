<?php

namespace Bookshop\BookshopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchController extends Controller {

    public function searchAction() {

        $string = $_GET['q'];
        $em = $this->get('doctrine.orm.entity_manager');
        $categs = $em->getRepository('BookshopBookshopBundle:Category')->findAll();
        $dql = "Select a from BookshopBookshopBundle:Product a where a.active = 1 and a.title like '%" . $string . "%' ";
        if (isset($_GET['stock']))
            switch ($_GET['stock']) {
                case '1':
                    $dql .= ' and a.stock>0';
                    break;
                case '0':
                    $dql .= ' and a.stock=0';
            }
        if (isset($_GET['category'])) {
            if (ctype_digit($_GET['category'])) {
                $dql .= ' and a.category = ' . $_GET['category'];
            }
        }
        if (isset($_GET['pricerange'])) {
            switch ($_GET['pricerange']) {
                case '1':
                    $dql .= ' and a.price between 0 and 49.99';
                    break;
                case '2':
                    $dql .= ' and a.price between 50 and 99.99';
                    break;
                case '3':
                    $dql .= ' and a.price>100';
                    break;
            }
        }
        $query = $em->createQuery($dql);

        if (isset($_GET['sort']))
            if (($_GET['sort'] != 'a.price') && ($_GET['sort'] != 'a.title')) {
                unset($_GET['sort']);
            }
        if (isset($_GET['page']))
            if (!ctype_digit($_GET['page']))
                $_GET['page'] = '1';
        if (isset($_GET['direction']))
            if (($_GET['direction'] != 'asc') && ($_GET['direction'] != 'desc'))
                $_GET['direction'] = 'asc';


        $paginator = $this->get('knp_paginator');
        $products = $paginator->paginate(
                $query, $this->get('request')->query->get('page', 1)/* page number */, 9/* limit per page */
        );



        return $this->render('BookshopBookshopBundle:Default:search.html.twig', array(
                    'products' => $products,
                    'string' => $string,
                    'categories' => $categs
        ));
    }

}

