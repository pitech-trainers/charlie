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
        $query = $em->getRepository('BookshopBookshopBundle:User')->getUsers();

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
        $form = $this->createForm(
                                    new UserEditFormType(), 
                                    $user,
                                    array('validation_groups' => array('Edit'))
                                  );
        
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
        }

        if ($form->isValid()) {
            $em->persist($user);
            $em->flush($user);
            return $this->redirect($this->generateUrl('bookshop_admin_user_list'));
        }
        
        return $this->render('BookshopAdminBundle:UserAdmin:edit.html.twig', array('form' => $form->createView(), 'userID' => $user->getId()));
    }
    
    
    

}

?>
