<?php

namespace Bookshop\BookshopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bookshop\BookshopBundle\Entity\User;
use Bookshop\BookshopBundle\Entity\Address;
use Bookshop\BookshopBundle\Form\Type\BillingAddressFormType;

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
        $billingAddress = $user->getBillingAddress();

        $form = $this->createForm(new BillingAddressFormType(), $billingAddress);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
        }

        if ($form->isValid()) {
            $em = $this->getDoctrine()
                    ->getManager();
            $em->persist($billingAddress);
            $em->flush();

            return $this->redirect($this->generateUrl('dashboard_index'));
        }

        return $this->render('BookshopBookshopBundle:Dashboard:billingAddressEdit.html.twig', array('form' => $form->createView()));
    }

    public function billingAddressPreEditAction() {
        $user = new User();
        $user = $this->get('security.context')->getToken()->getUser();
        $billingAddress = $user->getBillingAddress();

        $form = $this->createForm(new BillingAddressFormType(), $billingAddress);

        return $this->render('BookshopBookshopBundle:Dashboard:billingAddrPreEdit.html.twig', array('billing_address' => $billingAddress));
    }

}
