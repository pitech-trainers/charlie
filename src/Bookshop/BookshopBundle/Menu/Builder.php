<?php

// src/Acme/DemoBundle/Menu/Builder.php

namespace Bookshop\BookshopBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware {

    public function linksMenu(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem('root');
        $myTrans = $this->container->get('translator');

        $securityContext = $this->container->get('security.context');

        $menu->addChild('Home', array(
            'route' => 'bookshop_bookshop_homepage'
        ));



        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            $myAccountTrans = $myTrans->trans('menu.my.account', array(), 'BookshopBundle');
            $menu->addChild($myAccountTrans, array(
                'route' => 'fos_user_profile_show'
            ));
            $menu->addChild('Checkout', array(
                'route' => 'checkout'
            ));

            $myCartTrans = $myTrans->trans('menu.my.cart', array(), 'BookshopBundle');
            $menu->addChild($myCartTrans, array(
                'route' => 'bookshop_bookshop_homepage'
            ));

            $logoutTrans = $myTrans->trans('layout.logout', array(), 'FOSUserBundle');
            $menu->addChild($logoutTrans, array('route' => 'fos_user_security_logout'));
        } else {

            $menu->addChild('Checkout', array(
                'route' => 'checkout'
            ));

            $myCartTrans = $myTrans->trans('menu.my.cart', array(), 'BookshopBundle');
            $menu->addChild($myCartTrans, array(
                'route' => 'bookshop_bookshop_homepage'
            ));

            $loginTrans = $myTrans->trans('layout.login', array(), 'FOSUserBundle');
            $menu->addChild($loginTrans, array('route' => 'fos_user_security_login'));

//            $rstPassTrans = $myTrans->trans('menu.forgot_pass', array(), 'BookshopBundle');
//            $menu->addChild($rstPassTrans, array('route' => 'fos_user_resetting_request'));
//            $registerTrans = $myTrans->trans('menu.register', array(), 'BookshopBundle');
//            $menu->addChild($registerTrans, array('route' => 'fos_user_registration_register'));
        }
        return $menu;
    }

    public function mainMenu(FactoryInterface $factory, array $options) {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $categs = $em->getRepository('BookshopBookshopBundle:Category')->findAll();
        $menu = $factory->createItem('root');
        foreach ($categs as $categ) {
            $menu->addChild($categ->getName(), array(
                'route' => 'category',
                'routeParameters' => array('id' => $categ->getID())));
        }
        return $menu;
    }

}
