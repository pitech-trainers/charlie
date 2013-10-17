<?php

namespace Bookshop\BookshopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="Bookshop\BookshopBundle\Entity\ProductRepository")
 */
class Product {

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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category", referencedColumnName="id")
     * 
     */
    private $category;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="author", type="integer")
     */
    private $author;

    /**
     * @var integer
     *
     * @ORM\Column(name="isbn", type="integer")
     */
    private $isbn;

    /**
     * @var integer
     *
     * @ORM\Column(name="year", type="integer")
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=5000)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="shortdescription", type="string", length=500)
     */
    private $shortdescription;

    /**
     * @var integer
     *
     * @ORM\Column(name="stock", type="integer")
     */
    private $stock;

    /**
     * @var integer
     *
     * @ORM\Column(name="active", type="integer")
     */
    private $active;

    /**
     * @ORM\OneToOne(targetEntity="Image")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     * */
    private $image;
    
     /**
     * @ORM\OneToMany(targetEntity="CartItems", mappedBy="productId")
     */
    private $cartitems;
    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Product
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set category
     *
     * @param integer $category
     * @return Product
     */
    public function setCategory($category) {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return integer 
     */
    public function getCategory() {
        return $this->category;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Product
     */
    public function setPrice($price) {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Set author
     *
     * @param integer $author
     * @return Product
     */
    public function setAuthor($author) {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return integer 
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * Set isbn
     *
     * @param integer $isbn
     * @return Product
     */
    public function setIsbn($isbn) {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Get isbn
     *
     * @return integer 
     */
    public function getIsbn() {
        return $this->isbn;
    }

    /**
     * Set year
     *
     * @param integer $year
     * @return Product
     */
    public function setYear($year) {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer 
     */
    public function getYear() {
        return $this->year;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set shortdescription
     *
     * @param string $shortdescription
     * @return Product
     */
    public function setShortdescription($shortdescription) {
        $this->shortdescription = $shortdescription;

        return $this;
    }

    /**
     * Get shortdescription
     *
     * @return string 
     */
    public function getShortdescription() {
        return $this->shortdescription;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     * @return Product
     */
    public function setStock($stock) {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return integer 
     */
    public function getStock() {
        return $this->stock;
    }

    /**
     * Set active
     *
     * @param integer $active
     * @return Product
     */
    public function setActive($active) {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return integer 
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * Set image
     *
     * @param \Bookshop\BookshopBundle\Entity\Image $image
     * @return Product
     */
    public function setImage(\Bookshop\BookshopBundle\Entity\Image $image = null) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Bookshop\BookshopBundle\Entity\Image 
     */
    public function getImage() {
        return $this->image;
    }

}