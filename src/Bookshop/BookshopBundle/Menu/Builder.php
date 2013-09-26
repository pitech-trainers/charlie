<?php
// src/Acme/DemoBundle/Menu/Builder.php
namespace Bookshop\BookshopBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
//    public function mainMenu(FactoryInterface $factory, array $options)
//    {
//        $menu = $factory->createItem('root');
//        $myTrans = $this->container->get('translator');
//        
//        $homeTrans = $myTrans->trans('menu.home', array() ,'AcmeDemoBundle');
//        $menu->addChild($homeTrans, array('route' => '_welcome'));
//        $menu->addChild('Demo page', array(
//            'route' => '_demo'
////            'routeParameters' => array('id' => 42)
//        ));
//        $securityContext = $this->container->get('security.context');
//        if( $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') ){
//            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
//            $logoutTrans = $myTrans->trans('layout.logout', array() ,'FOSUserBundle');
//            $menu->addChild($logoutTrans, array('route' => 'fos_user_security_logout'));
//            
//        }else{
//            $loginTrans = $myTrans->trans('layout.login', array() ,'FOSUserBundle');
//            $menu->addChild($loginTrans, array('route' => 'fos_user_security_login'));
//            $rstPassTrans = $this->container->get('translator')->trans('menu.reset_pass', array() ,'AcmeDemoBundle');
//            $menu->addChild($rstPassTrans, array('route' => 'fos_user_resetting_request'));
//            $menu->addChild("Item With Childs", array('route' => '_welcome'));
//            $menu['Item With Childs']->addChild('first Cild', array('route' => '_welcome'));
//            $menu['Item With Childs']->addChild('second Cild', array('route' => '_welcome'));
//        }
//        
//        
//        // ... add more children
//
//        return $menu;
//    }
    
    public function categoryMenu(FactoryInterface $factory, array $options){
        $em = $this->container->get('doctrine.orm.entity_manager');
        $categs = $em->getRepository('BookshopBookshopBundle:Category')->findAll();
        $menu = $factory->createItem('root');
        foreach ($categs as $categ) {
            $menu->addChild($categ->getName(),  array(
            'route' => 'category',
            'routeParameters' => array('id' => $categ->getID())));
        }
        return $menu;
    }
}