<?php

namespace Bookshop\BookshopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Bookshop\BookshopBundle\Form\Type\CheckoutBillingFormType;
use Bookshop\BookshopBundle\Entity\Address;

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
        if (!$this->getUser()) {
            $this->getRequest()->getSession()->getFlashBag()->add('error', "Please login before checkout!");
            $url = $this->getRequest()->headers->get("referer");
            return new RedirectResponse($url);
        }
        $user = $this->getUser();
        $userid = $this->getUser()->getID();

        $em = $this->getDoctrine()->getManager();
        $cart = $em->getRepository('BookshopBookshopBundle:Cart')->getCart($userid);
        $order = $em->getRepository('BookshopBookshopBundle:BookshopOrder')->getCurrentOrder($userid, $cart[0]->getId());
        $address = new Address();
        if ($user->getBillingAddress()) {
            $address = $user->getBillingAddress();
        }
        $request = $this->getRequest();

        $form = $this->createForm(new CheckoutBillingFormType(), $address);
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
        }

        if ($form->isValid()) {
            $em->persist($address);
            $em->flush($address);
            $order->setBillingAddress($address);
            if ($address->getShippToThis())
                $order->setShippingAddress($address);
            $order->setCart($cart);
            $em->persist($order);
            $em->flush($order);
            
            if (!$address->getShippToThis())
                return $this->redirect($this->generateUrl('shipping'));
            else
                return $this->redirect($this->generateUrl('shipping_method'));
        }

        return $this->render('BookshopBookshopBundle:Checkout:billing.html.twig', array('form' => $form->createView()));
    }

    public function shippingAction() {
        return $this->render('BookshopBookshopBundle:Checkout:shipping.html.twig');
    }

    public function shippingMethodAction() {
        return $this->render('BookshopBookshopBundle:Checkout:methodshipping.html.twig');
    }

    public function paymentAction() {
        return $this->render('BookshopBookshopBundle:Checkout:payment.html.twig');
    }

    public function reviewAction() {
        return $this->render('BookshopBookshopBundle:Checkout:review.html.twig');
    }

}