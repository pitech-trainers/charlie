<?php

// src/Bookshop\BookshopBundle\Entity/User.php

namespace Bookshop\BookshopBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=false)
     * 
     * @Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
     * @Assert\Regex(
     *     pattern="/^[A-Z a-z]+$/",
     *     htmlPattern="*",
     *     match=true,
     *     message="The name contains leters only."
     * )
     */
    protected $first_name;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=false)
     * 
     * @Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
     * @Assert\Regex(
     *     pattern="/^[A-Z a-z]+$/",
     *     htmlPattern="*",
     *     match=true,
     *     message="The name contains leters only."
     * )
     */
    protected $last_name;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=20, nullable=false)
     * 
     * @Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
     * @Assert\Regex(
     *     pattern="/^\d+$/",
     *     htmlPattern="*",
     *     match=true,
     *     message="This mobile number is invalid."
     * )
     * @Assert\Regex(
     *     pattern="/^\d{10,12}$/",
     *     htmlPattern="*",
     *     match=true,
     *     message="This mobile number must contain 10 or 12 digits."
     * )
     * 
     * 
     */
    protected $mobile;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=1, nullable=true)
     */
    protected $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="education", type="string", length=1, nullable=true)
     */
    protected $education;

    /**
     * @var string
     * 
     * @ORM\OneToOne(targetEntity="Address")
     * @ORM\JoinColumn(name="billing_address_id", referencedColumnName="id")
     */
    protected $billing_address;

    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="Address")
     * @ORM\JoinColumn(name="shipping_address_id", referencedColumnName="id")
     */
    protected $shipping_address;

    public function __construct() {
        parent::__construct();
        // your own logic
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set first_name
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName) {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get first_name
     *
     * @return string 
     */
    public function getFirstName() {
        return $this->first_name;
    }

    /**
     * Set last_name
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName) {
        $this->last_name = $lastName;
        return $this;
    }

    /**
     * Get last_name
     *
     * @return string 
     */
    public function getLastName() {
        return $this->last_name;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     * @return User
     */
    public function setMobile($mobile) {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * Get mobile
     *
     * @return string 
     */
    public function getMobile() {
        return $this->mobile;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return User
     */
    public function setGender($gender) {
        $this->gender = $gender;
        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender() {
        return $this->gender;
    }

    /**
     * Set education
     *
     * @param string $education
     * @return User
     */
    public function setEducation($education) {
        $this->education = $education;
        return $this;
    }

    /**
     * Get education
     *
     * @return string 
     */
    public function getEducation() {
        return $this->education;
    }

    /**
     * Set billing_address
     *
     * @param \Bookshop\BookshopBundle\Entity\Address $billingAddress
     * @return User
     */
    public function setBillingAddress(\Bookshop\BookshopBundle\Entity\Address $billingAddress = null) {
        $this->billing_address = $billingAddress;
        return $this;
    }

    /**
     * Get billing_address
     *
     * @return \Bookshop\BookshopBundle\Entity\Address 
     */
    public function getBillingAddress() {
        return $this->billing_address;
    }

    /**
     * Set shipping_address
     *
     * @param \Bookshop\BookshopBundle\Entity\Address $shippingAddress
     * @return User
     */
    public function setShippingAddress(\Bookshop\BookshopBundle\Entity\Address $shippingAddress = null) {
        $this->shipping_address = $shippingAddress;
        return $this;
    }

    /**
     * Get shipping_address
     *
     * @return \Bookshop\BookshopBundle\Entity\Address 
     */
    public function getShippingAddress() {
        return $this->shipping_address;
    }

}