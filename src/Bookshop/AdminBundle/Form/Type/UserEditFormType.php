<?php

// src/Bookshop/BookshopBundle/Form/Type/ProfileFormType.php

namespace Bookshop\AdminBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class UserEditFormType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
        // add your custom field
        $builder->add('username');
        $builder->add('first_name');
        $builder->add('last_name');
        
//        $builder->add('billing_address_id');
//        $builder->add('shipping_address_id');
    }

    public function getName() {
        return 'admin_user_edit';
    }

}