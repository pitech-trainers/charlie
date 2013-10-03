<?php

namespace Bookshop\BookshopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CheckoutController extends Controller {

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