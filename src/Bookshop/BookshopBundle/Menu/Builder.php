<?php

// src/Acme/DemoBundle/Menu/Builder.php

namespace Bookshop\BookshopBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware {

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
