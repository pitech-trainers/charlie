<?php

namespace Bookshop\BookshopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CartController extends Controller {

    public function indexAction() {

        if (is_null($this->getUser()))
            $userid = 0;
        else
            $userid = $this->getUser()->getID();

        $em = $this->getDoctrine()->getManager();

        $cart = $em->getRepository('BookshopBookshopBundle:Cart')->getCart($userid);

        if (sizeof($cart) == 0) {
            $cartmodel = new \Bookshop\BookshopBundle\Entity\Cart;
            $cartmodel->setUserId($userid);
            $cartmodel->setDate(date('Y-m-d'));
            $cartmodel->setTotal(0);
            $cartmodel->setActive(1);
            $em->persist($cartmodel);
            $em->flush();
            $cart = $em->getRepository('BookshopBookshopBundle:Cart')->getCart($userid);
        }
        $cartid = $cart[0]->getId();

        $cartitems = $em->getRepository('BookshopBookshopBundle:CartItems')->getItems($cartid);

        return $this->render('BookshopBookshopBundle:Cart:index.html.twig', array(
                    'items' => $cartitems,
                    'cart' => $cart[0]
                        )
        );
    }

}
