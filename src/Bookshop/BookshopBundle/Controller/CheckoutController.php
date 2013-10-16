<?php

namespace Bookshop\BookshopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CheckoutController extends Controller {

    public function indexAction() {
        if (is_null($this->getUser()))
            $userid = 0;
        else
            $userid = $this->getUser()->getID();
        $em = $this->getDoctrine()->getManager();
        $cart = $em->getRepository('BookshopBookshopBundle:Cart')->getCart($userid);
        $cartid = $cart[0]->getId();
        $cartitems = $em->getRepository('BookshopBookshopBundle:CartItems')->getItems($cartid);
        if (sizeof($cartitems) == 0) {
            return $this->render("BookshopBookshopBundle:Error:Empty.html.twig");
        } else {
            return $this->redirect($this->generateUrl('billing'));
        }
    }

    public function billingAction() {
        return $this->render('BookshopBookshopBundle:Checkout:billing.html.twig');
    }

    public function shippingAction() {
        return $this->render('BookshopBookshopBundle:Checkout:shipping.html.twig');
    }

    public function shippingmethodAction() {
        return $this->render('BookshopBookshopBundle:Checkout:methodshipping.html.twig');
    }

    public function paymentAction() {
        return $this->render('BookshopBookshopBundle:Checkout:payment.html.twig');
    }

    public function reviewAction() {
        return $this->render('BookshopBookshopBundle:Checkout:review.html.twig');
    }

}