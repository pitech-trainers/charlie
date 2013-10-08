<?php

namespace Bookshop\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of UserAdminController
 *
 * @author mzaharie
 */
class UserAdminController extends Controller{
    
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository("BookshopBookshopBundle:User")->findAll();
        $dql = "SELECT u FROM BookshopBookshopBundle:User u";
        $query = $em->createQuery($dql);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, $this->get('request')->query->get('page', 1)/* page number */, 9/* limit per page */
        );
        return $this->render('BookshopAdminBundle:Default:index.html.twig', array('users' => $pagination));
    }
}

?>
