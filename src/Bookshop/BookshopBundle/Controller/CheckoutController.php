<?php

namespace Bookshop\BookshopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Bookshop\BookshopBundle\Form\Type\CheckoutBillingFormType;
use Bookshop\BookshopBundle\Form\Type\ShippingMethodFormType;
use Bookshop\BookshopBundle\Form\Type\AddressFormType;
use Bookshop\BookshopBundle\Entity\Address;
use Bookshop\BookshopBundle\Entity\BookshopOrder;
use Bookshop\BookshopBundle\Entity\ShippingMethod;

class CheckoutController extends Controller {

    public function indexAction() {
        if (is_null($this->getUser()))
            $userid = 0;
        else
            $userid = $this->getUser()->getID();
        $em = $this->getDoctrine()->getManager();
        $cart = $em->getRepository('BookshopBookshopBundle:Cart')->getCart($userid);
        $cartid = $cart->getId();
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
        $order = $em->getRepository('BookshopBookshopBundle:BookshopOrder')->getCurrentOrder($userid);
        if(!$order){
            $order = new BookshopOrder();
        }
        
        
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
                return $this->redirect($this->generateUrl('shipping_method',array('back_route' => 'billing')));
        }

        return $this->render('BookshopBookshopBundle:Checkout:billing.html.twig', array('form' => $form->createView()));
    }

    public function shippingAction() 
    {
        if (!$this->getUser()) {
            $this->getRequest()->getSession()->getFlashBag()->add('error', "Please login before checkout!");
            $url = $this->getRequest()->headers->get("referer");
            return new RedirectResponse($url);
        }
        $step = $this->dispatchToStep();
        if($step != false && $step != 'shipping' && $step != 'shipping_method' && $step != 'payment'){
            return $this->redirect($this->generateUrl($step));
        }
        
        $user = $this->getUser();
        $userid = $this->getUser()->getID();

        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository('BookshopBookshopBundle:BookshopOrder')->getCurrentOrder($userid);
        $address = new Address();
        if ($user->getShippingAddress()) {
            $address = $user->getShippingAddress();
        }
        $request = $this->getRequest();

        $form = $this->createForm(new AddressFormType(), $address);
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
        }
        
        if($form->isValid()){
            $em->persist($address);
            $em->flush($address);
            $order->setShippingAddress($address);
            $em->persist($order);
            $em->flush($order);
            return $this->redirect($this->generateUrl('shipping_method', array('back_route' => 'shipping')));
        }
        
        return $this->render('BookshopBookshopBundle:Checkout:shipping.html.twig', array('form' => $form->createView()));
    }

    public function shippingMethodAction(Request $request) {
        if (!$this->getUser()) {
            $this->getRequest()->getSession()->getFlashBag()->add('error', "Please login before checkout!");
            $url = $this->getRequest()->headers->get("referer");
            return new RedirectResponse($url);
        }
        $step = $this->dispatchToStep();
        if($step != false && $step != 'shipping_method' && $step != 'payment'){
            return $this->redirect($this->generateUrl($step));
        }
        
        $user = $this->getUser();
        $userid = $this->getUser()->getID();

        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository('BookshopBookshopBundle:BookshopOrder')->getCurrentOrder($userid);
        $request = $this->getRequest();

        $form = $this->createForm(new ShippingMethodFormType($em), $order);
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
        }
        
        if($form->isValid()){
            $order->setTotal($order->getTotal()+$order->getShipping()->getPrice());
            $em->persist($order);
            $em->flush($order);
            return $this->redirect($this->generateUrl('payment'));
        }
        return $this->render('BookshopBookshopBundle:Checkout:methodshipping.html.twig', array('form' => $form->createView(),'back_route' => $request->query->get('back_route')));
    }

    public function paymentAction() {
        return $this->render('BookshopBookshopBundle:Checkout:payment.html.twig');
    }

    public function reviewAction() {
        return $this->render('BookshopBookshopBundle:Checkout:review.html.twig');
    }
    
    private function dispatchToStep(){
        $user = $this->getUser();
        $userid = $user->getID();

        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository('BookshopBookshopBundle:BookshopOrder')->getCurrentOrder($userid);
        
        if(!$order->getBillingAddress())
            return 'billing';
        elseif(!$order->getShippingAddress())
            return 'shipping';
        elseif(!$order->getShipping())
            return 'shipping_method';
        else
            return false;
        
    }

}