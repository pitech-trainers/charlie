<?php

namespace Bookshop\BookshopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bookshop\BookshopBundle\Entity\User;
use Bookshop\BookshopBundle\Entity\Address;
use Bookshop\BookshopBundle\Form\Type\AddressFormType;

class DashboardController extends Controller {

    public function indexAction() {
        $user = $this->get('security.context')->getToken()->getUser();

        return $this->render('BookshopBookshopBundle:Dashboard:index.html.twig');
    }

    public function billingAddressShowAction() {
        $user = new User();
        $user = $this->get('security.context')->getToken()->getUser();
        $billingAddress = $user->getBillingAddress();

        //$em = $this->getDoctrine()->getManager();
        //$entity = $em->getRepository('BookshopBundle:Address')->find($id);

        return $this->render('BookshopBookshopBundle:Dashboard:billingAddressShow.html.twig', array('billing_address' => $billingAddress));
    }

    public function shippingAddressShowAction() {
        $user = new User();
        $user = $this->get('security.context')->getToken()->getUser();
        $shippingAddress = $user->getShippingAddress();

        //$em = $this->getDoctrine()->getManager();
        //$entity = $em->getRepository('BookshopBundle:Address')->find($id);

        return $this->render('BookshopBookshopBundle:Dashboard:shippingAddressShow.html.twig', array('shipping_address' => $shippingAddress));
    }

    public function billingAddressEditAction() {
        $user = new User();
        $user = $this->get('security.context')->getToken()->getUser();
        $billingAddress = new Address();
        if (!is_null($user->getBillingAddress())) {
            $billingAddress = $user->getBillingAddress();
        }

        $form = $this->createForm(new AddressFormType(), $billingAddress);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
        }

        if ($form->isValid()) {
            $em = $this->getDoctrine()
                    ->getManager();
            if ($billingAddress->getId() == $user->getShippingAddress()->getId() && !is_null($user->getBillingAddress())) {

                $newBillingAddress = new Address();
                $newBillingAddress->copy($billingAddress);
                $billingAddress = $newBillingAddress;
            }

            $em->persist($billingAddress);
            $em->flush($billingAddress);

            $user->setBillingAddress($billingAddress);
            $em->persist($user);
            $em->flush($user);

            return $this->redirect($this->generateUrl('dashboard_index'));
        }

        return $this->render('BookshopBookshopBundle:Dashboard:billingAddressEdit.html.twig', array('form' => $form->createView()));
    }

    public function billingAddressPreEditAction() {
        $user = new User();
        $user = $this->get('security.context')->getToken()->getUser();
        $billingAddress = new Address();
        if (!is_null($user->getBillingAddress())) {
            $billingAddress = $user->getBillingAddress();
        }

        return $this->render('BookshopBookshopBundle:Dashboard:billingAddrPreEdit.html.twig', array('billing_address' => $billingAddress));
    }
    
//    public function shippingAddressPreEditAction() {
//        $user = new User();
//        $user = $this->get('security.context')->getToken()->getUser();
//        $shippingAddress = new Address();
//        if (!is_null($user->getShippingAddresss())) {
//            $shippingAddress = $user->getShippingAddresss();
//        }
//
//        return $this->render('BookshopBookshopBundle:Dashboard:shippingAddrPreEdit.html.twig', array('shipping_address' => $shippingAddress));
//    }

}
