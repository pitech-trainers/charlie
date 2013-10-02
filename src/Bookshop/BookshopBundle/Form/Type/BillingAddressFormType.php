<?php
// src/Blogger/BlogBundle/Form/CommentType.php

namespace Bookshop\BookshopBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BillingAddressFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('address')
            ->add('city')
            ->add('country')
        ;
    }

    public function getName()
    {
        return 'default_billing_address_type';
    }
}