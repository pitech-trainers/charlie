<?php

namespace Bookshop\BookshopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $lastprod = $em->getRepository('BookshopBookshopBundle:Product')->getLast(6);
         if (!$lastprod) {
            throw $this->createNotFoundException('Unable to find last products.');
        }        
        
        return $this->render(
            'BookshopBookshopBundle:Default:homepage.html.twig',
            array(
                'lastProducts' => $lastprod
            )
        );
    }
}
