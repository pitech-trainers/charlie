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
        if ($this->match($_POST['cartid']) == 1) {
            $em = $this->getDoctrine()->getManager();
            $cartitems = $em->getRepository('BookshopBookshopBundle:CartItems')->getItems($_POST['cartid']);
            $success = 1;
            if (isset($_POST['qty'])) {
                foreach ($_POST['qty'] as $key => $value)
                    foreach ($cartitems as $cartitem)
                        if ($cartitem->getID() == $key)
                            if ($value <= $cartitems[0]->getProductID()->getStock()) {
                                if ($value > 0) {
                                    $cartitem->setQuantity($value);
                                    $em->persist($cartitem);
                                } else {
                                    $this->deleteproductAction($cartitem->getID(), $_POST['cartid']);
                                }
                            } else {
                                $success = 0;
                            }
                $em->flush();
            }
            if ($success == 0)
                $this->getRequest()->getSession()->getFlashBag()->add('error', 'Some values were not updated');
            else
                $this->getRequest()->getSession()->getFlashBag()->add('success', 'Cart has been updated');
            $this->updateTotalCart($_POST['cartid']);
            $referer = $this->getRequest()->headers->get('referer');
            return $this->redirect($referer);
        } else {
            return $this->render('BookshopBookshopBundle:Error:Error.html.twig');
        }
    }

    public function deleteproductAction($id, $cartid) {
        if ($this->match($cartid) == 1) {
            $em = $this->getDoctrine()->getManager();
            $cart = $em->getRepository('BookshopBookshopBundle:Cart')->getCartbyId($cartid);
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
            $this->getRequest()->getSession()->getFlashBag()->add('success', 'Product deleted');
            $referer = $this->getRequest()->headers->get('referer');
            return $this->redirect($referer);
        } else {
            return $this->render('BookshopBookshopBundle:Error:Error.html.twig');
        }
    }

    public function emptycartAction($cartid) {
        if ($this->match($cartid) == 1) {
            $em = $this->getDoctrine()->getManager();
            $cart = $em->getRepository('BookshopBookshopBundle:Cart')->getCartbyId($cartid);
            $cartitems = $em->getRepository('BookshopBookshopBundle:CartItems')->getItems($cartid);
            if (!(empty($cartitems))) {
                foreach ($cartitems as $cartitem) {
                    $em->remove($cartitem);
                    $em->flush();
                }
            }
            $this->updateTotalCart($cartid);
            $this->getRequest()->getSession()->getFlashBag()->add('success', 'Cart is now empty');
            $referer = $this->getRequest()->headers->get('referer');

            return $this->redirect($referer);
        } else {
            return $this->render('BookshopBookshopBundle:Error:Error.html.twig');
        }
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
        $success = 1;
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
            } else {
                $success = 0;
            }
        } else {
            if ($quantity + $existitem[0]->getQuantity() <= $product[0]->getStock()) {
                $existitem[0]->setQuantity($existitem[0]->getQuantity() + $quantity);
                $em->persist($cart[0]);
                $em->persist($existitem[0]);
                $em->flush();
            } else {
                $success = 0;
            }
        }
        if ($success == 0)
            $this->getRequest()->getSession()->getFlashBag()->add('error', "We don't have the quantity you requested");
        else
            $this->getRequest()->getSession()->getFlashBag()->add('success', 'Product was successfully added');
        $this->updateTotalCart($cart[0]->getId());
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
        if ($this->match($cartid) == 1) {
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
        } else {
            return $this->render('BookshopBookshopBundle:Error:Error.html.twig');
        }
    }

    private function match($cartid) {
        if (is_null($this->getUser()))
            $userid = 0;
        else
            $userid = $this->getUser()->getID();
        $em = $this->getDoctrine()->getManager();
        $cart = $em->getRepository('BookshopBookshopBundle:Cart')->getCartbyId($cartid);
        if ($userid != $cart[0]->getUserID()) {
            return 0;
        } else {
            return 1;
        }
    }

}
