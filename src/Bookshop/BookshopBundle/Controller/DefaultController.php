<?php

namespace Bookshop\BookshopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BookshopBookshopBundle:Default:homepage.html.twig');
    }
    
    public function categoryAction($id){
        return $this->render('BookshopBookshopBundle::layout.html.twig');
        
    }
}
