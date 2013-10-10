<?php

namespace Bookshop\BookshopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CartController extends Controller {

    public function mycartAction() {
        if (is_null($this->getUser()))
            $userid = 0;
        else
            $userid = $this->getUser()->getID();
        $em = $this->getDoctrine()->getManager();
        $cart = $em->getRepository('BookshopBookshopBundle:Cart')->getCart($userid);
        $cartid = $cart[0]->getId();
        $cartitems = $em->getRepository('BookshopBookshopBundle:CartItems')->getItems($cartid);

        return $this->render('BookshopBookshopBundle:Default:mycart.html.twig', array(
                    'items' => $cartitems,
                    'cart' => $cart[0]
                        )
        );
    }

    public function updatecartAction() {
        $em = $this->getDoctrine()->getManager();
        $cartitems = $em->getRepository('BookshopBookshopBundle:CartItems')->getItems($_POST['cartid']);
        foreach ($_POST['qty'] as $key => $value)
            foreach ($cartitems as $cartitem)
                if ($cartitem->getID() == $key && $value <= $cartitems[0]->getProductID()->getStock()) {
                    $cartitem->setQuantity($value);
                    $em->persist($cartitem);
                }
        $em->flush();
        $this->updateTotalCart($_POST['cartid']);
        $referer = $this->getRequest()->headers->get('referer');

        return $this->redirect($referer);
    }

    public function deleteproductAction($id, $cartid) {
        $em = $this->getDoctrine()->getManager();
        $cartitems = $em->getRepository('BookshopBookshopBundle:CartItems')->getItems($cartid);
        if (!(empty($cartitems))) {
            foreach ($cartitems as $cartitem) {
                if ($cartitem->getId() == $id) {
                    $em->remove($cartitem);
                    $em->flush();
                }
            }
        }
        $this->updateTotalCart($cartid);
        $referer = $this->getRequest()->headers->get('referer');

        return $this->redirect($referer);
    }

    public function emptycartAction($cartid) {
        $em = $this->getDoctrine()->getManager();
        $cartitems = $em->getRepository('BookshopBookshopBundle:CartItems')->getItems($cartid);
        if (!(empty($cartitems))) {
            foreach ($cartitems as $cartitem) {
                $em->remove($cartitem);
                $em->flush();
            }
        }
        $this->updateTotalCart($cartid);
        $referer = $this->getRequest()->headers->get('referer');

        return $this->redirect($referer);
    }

    public function addproductAction() {
        $em = $this->getDoctrine()->getManager();
        if (isset($_POST['productid']))
            if (ctype_digit($_POST['productid']))
                $productid = $_POST['productid'];
        if (isset($_POST['quantity']))
            if (ctype_digit($_POST['quantity']))
                $quantity = $_POST['quantity'];
        if (is_null($this->getUser()))
            $userid = 0;
        else
            $userid = $this->getUser()->getID();
        $em = $this->getDoctrine()->getManager();
        $cart = $em->getRepository('BookshopBookshopBundle:Cart')->getCart($userid);
        $product = $em->getRepository('BookshopBookshopBundle:Product')->retrieveProduct($productid);
        $existitem = $em->getRepository('BookshopBookshopBundle:CartItems')->getCartItem($productid, $cart[0]->getId());
        if (empty($existitem[0])) {
            if ($quantity <= $product[0]->getStock()) {
                $cartitem = new \Bookshop\BookshopBundle\Entity\CartItems;
                $cartitem->setPrice($product[0]->getPrice());
                $cartitem->setTitle($product[0]->getTitle());
                $cartitem->setQuantity($quantity);
                $cartitem->setProductId($product[0]);
                $cartitem->setCartId($cart[0]);
                $em->persist($cartitem);
                $em->flush();
            }
        } else {
            if ($quantity + $existitem[0]->getQuantity() <= $product[0]->getStock()) {
                $existitem[0]->setQuantity($existitem[0]->getQuantity() + $quantity);
                $em->persist($cart[0]);
                $em->persist($existitem[0]);
                $em->flush();
            }
        }
        $this->updateTotalCart($cart[0]->getId());
        $referer = $this->getRequest()->headers->get('referer');

        return $this->redirect($referer);
    }

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

    private function updateTotalCart($cartid) {
        if (is_null($this->getUser()))
            $userid = 0;
        else
            $userid = $this->getUser()->getID();
        $em = $this->getDoctrine()->getManager();
        $cart = $em->getRepository('BookshopBookshopBundle:Cart')->getCart($userid);
        $cartitems = $em->getRepository('BookshopBookshopBundle:CartItems')->getItems($cartid);

        $cart[0]->setTotal(0.00);

        foreach ($cartitems as $item) {
            $cart[0]->setTotal($item->getQuantity() * $item->getPrice() + $cart[0]->getTotal());
        }
        $em->persist($cart[0]);
        $em->flush();
    }

}
