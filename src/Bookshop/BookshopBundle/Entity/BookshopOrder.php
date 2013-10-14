<?php

namespace Bookshop\BookshopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BookshopOrder
 *
 * @ORM\Table(name = "orders")
 * @ORM\Entity
 */
class BookshopOrder
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * 
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * 
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Address")
     * @ORM\JoinColumn(name="biling_address_id", referencedColumnName="id")
     */
    private $billingAddress;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Address")
     * @ORM\JoinColumn(name="shipping_address_id", referencedColumnName="id")
     * 
     */
    private $shippingAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="cart", type="string", length=255)
     */
    private $cart;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="decimal")
     */
    private $total;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="State")
     * @ORM\JoinColumn(name="state_id", referencedColumnName="id")
     * 
     */
    private $state;


    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cart
     *
     * @param string $cart
     * @return BookshopOrder
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
    
        return $this;
    }

    /**
     * Get cart
     *
     * @return string 
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Set total
     *
     * @param float $total
     * @return BookshopOrder
     */
    public function setTotal($total)
    {
        $this->total = $total;
    
        return $this;
    }

    /**
     * Get total
     *
     * @return float 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return BookshopOrder
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set user
     *
     * @param \Bookshop\BookshopBundle\Entity\User $user
     * @return BookshopOrder
     */
    public function setUser(\Bookshop\BookshopBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Bookshop\BookshopBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set billingAddress
     *
     * @param \Bookshop\BookshopBundle\Entity\Address $billingAddress
     * @return BookshopOrder
     */
    public function setBillingAddress(\Bookshop\BookshopBundle\Entity\Address $billingAddress = null)
    {
        $this->billingAddress = $billingAddress;
    
        return $this;
    }

    /**
     * Get billingAddress
     *
     * @return \Bookshop\BookshopBundle\Entity\Address 
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * Set shippingAddress
     *
     * @param \Bookshop\BookshopBundle\Entity\Address $shippingAddress
     * @return BookshopOrder
     */
    public function setShippingAddress(\Bookshop\BookshopBundle\Entity\Address $shippingAddress = null)
    {
        $this->shippingAddress = $shippingAddress;
    
        return $this;
    }

    /**
     * Get shippingAddress
     *
     * @return \Bookshop\BookshopBundle\Entity\Address 
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * Set state
     *
     * @param \Bookshop\BookshopBundle\Entity\State $state
     * @return BookshopOrder
     */
    public function setState(\Bookshop\BookshopBundle\Entity\State $state = null)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return \Bookshop\BookshopBundle\Entity\State 
     */
    public function getState()
    {
        return $this->state;
    }
}