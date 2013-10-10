<?php

namespace Bookshop\AdminBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
/**
 * Description of ProductAddFormType
 *
 * @author mzaharie
 */
class ProductAddFormType extends AbstractType{
    //put your code here
    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
        // add your custom field
        $builder->add('title');
        $builder->add('category');
        $builder->add('description');
        $builder->add('shortdescription');
        $builder->add('price');
        $builder->add('stock');
        $builder->add('file');
        
//        $builder->add('billing_address_id');
//        $builder->add('shipping_address_id');
    }

    public function getName() {
        return 'admin_product_add';
    }
}

?>
