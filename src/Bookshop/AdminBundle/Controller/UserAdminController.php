<?php

namespace Bookshop\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Bookshop\AdminBundle\Form\Type\UserEditFormType;

/**
 * Description of UserAdminController
 *
 * @author mzaharie
 */
class UserAdminController extends Controller 
{

    public function indexAction() 
    {
        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT u FROM BookshopBookshopBundle:User u WHERE u.roles not like '%ROLE_SUPER_ADMIN%'";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, 
                $this->get('request')->query->get('page', 1)/* page number */, 2/* limit per page */
        );
        return $this->render('BookshopAdminBundle:UserAdmin:index.html.twig', array('users' => $pagination));
    }

    public function enableAction($userID) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("BookshopBookshopBundle:User")->find($userID);
        $user->setEnabled(1);
        $em->persist($user);
        $em->flush($user);
        $url = $this->getRequest()->headers->get("referer");
        return new RedirectResponse($url);
    }
    
    public function disableAction($userID) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("BookshopBookshopBundle:User")->find($userID);
        $user->setEnabled(0);
        $em->persist($user);
        $em->flush($user);
        $url = $this->getRequest()->headers->get("referer");
        return new RedirectResponse($url);
    }
    
    public function editAction($userID) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("BookshopBookshopBundle:User")->find($userID);
        $form = $this->createForm(new UserEditFormType(), $user);
        //to do
        $em->persist($user);
        $em->flush($user);
        $url = $this->getRequest()->headers->get("referer");
        return new RedirectResponse($url);
    }
    
    
    

}

?>
