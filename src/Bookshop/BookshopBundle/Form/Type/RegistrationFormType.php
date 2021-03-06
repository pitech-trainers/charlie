<?php

// src/Bookshop/BookshopBundle/Form/Type/RegistrationFormType.php

namespace Bookshop\BookshopBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);

        // add your custom field
        $builder->add('first_name','text', array('required' => false));
        $builder->add('last_name', 'text', array('required' => false));
        $builder->add('mobile');
        $builder->add('gender', 'choice', array(
            'choices' => array('m' => 'Male', 'f' => 'Female'),
            'required' => true,
            'expanded' => true,
            'multiple' => false,
            
            'data' => 'm'
        ));
        $builder->add('education', 'choice', array(
            'choices' => array(
                '0' => '-- Choose one --',
                '1' => 'Under graduate',
                '2' => 'Graduate',
                '3' => 'University',
                '4' => 'Post university'
            ),
            'required' => true,
            'expanded' => false,
            'multiple' => false,
        ));
        
//        $builder->add('billing_address');
//        $builder->add('shipping_address_id');
    }

    public function getName() {
        return 'bookshop_user_registration';
    }

}