<?php

namespace Bookshop\BookshopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller {

    public function productAction($id) {

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('BookshopBookshopBundle:Product')->retrieveProduct($id);

        $categoryid = $product[0]->getCategory()->getId();

        $allproducts = $em->getRepository('BookshopBookshopBundle:Product')->relatedProducts($categoryid);

        $array = array_rand($allproducts, 4);

        for ($i = 0; $i < 4; $i++) {
            $relatedproducts[$i] = $allproducts[$array[$i]];
        }

        return $this->render('BookshopBookshopBundle:Default:productdetail.html.twig', array(
                    'product' => $product[0],
                    'relatedproducts' => $relatedproducts
                        )
        );
    }

}
