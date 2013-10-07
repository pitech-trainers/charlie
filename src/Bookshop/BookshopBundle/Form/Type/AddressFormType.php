<?php
// src/Blogger/BlogBundle/Form/CommentType.php

namespace Bookshop\BookshopBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AddressFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName','text', array('required' => false))
            ->add('lastName','text', array('required' => false))
            ->add('email','text', array('required' => false))
            ->add('address','text', array('required' => false))
            ->add('city','text', array('required' => false))
            ->add('country','text', array('required' => false))
        ;
    }

    public function getName()
    {
        return 'default_address_type';
    }
}