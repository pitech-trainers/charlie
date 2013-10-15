<?php

namespace Bookshop\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BookshopAdminBundle:Default:index.html.twig', array());
    }
    
    public function setLocaleAction($locale='ro'){  // needs route define
        $url = $this->getRequest()->headers->get("referer");
        $url.="&_locale=$locale"; //???
        return new RedirectResponse($url);
    }
}
